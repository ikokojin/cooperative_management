<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\lending_program_tbl;
use App\Models\lending_repayments_tbl;
use App\Models\lending_status_tbl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function payViaGcash(Request $request)
    {
        try {
            if (! env('PAYMONGO_SECRET_KEY')) {
                return redirect()->back()->with('error', 'Payment gateway is not configured yet.');
            }

            $loan = lending_program_tbl::findOrFail($request->lending_id);
            $paymentType = $request->payment_type ?? 'monthly'; // ADD THIS

            // Determine the correct amount to charge
            if ($paymentType === 'full') {
                $status = lending_status_tbl::where('lending_id', $loan->id)->first();
                $amount = $status ? $status->remaining_balance : $loan->total_payment;
            } else {
                // Schedule-based loans charge the CURRENT unpaid installment's
                // amount (varies as interest declines) plus any applicable 2%
                // late fee — the same rule as the cash/admin repayment paths.
                // Legacy loans use the stored average monthly payment.
                $currentInstallment = (new \App\Services\LoanCalculationService)->currentInstallment($loan->id, true);
                if ($currentInstallment) {
                    $status = lending_status_tbl::where('lending_id', $loan->id)->first();
                    $lateFee = $this->applicableLateFee($loan, $status, (float) $currentInstallment->amount_due)['fee'];
                    $amount = round((float) $currentInstallment->amount_due + $lateFee, 2);
                } else {
                    $amount = $loan->monthly_payment;
                }
            }

            $response = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
                ->withOptions(['verify' => false])
                ->post('https://api.paymongo.com/v1/sources', [
                    'data' => [
                        'attributes' => [
                            'amount' => (int) ($amount * 100), // use $amount instead of monthly_payment
                            'currency' => 'PHP',
                            'type' => 'gcash',
                            'redirect' => [
                                'success' => route('repayment.gcash.success', [
                                    'lending_id' => $loan->id,
                                    'payment_type' => $paymentType, // PASS IT TO SUCCESS URL
                                    'amount' => (float) $amount,   // exact charged total for callback validation
                                ]),
                                'failed' => route('repayment.gcash.failed', ['lending_id' => $loan->id]),
                            ],
                        ],
                    ],
                ]);

            $data = $response->json();

            if (isset($data['errors'])) {
                return redirect()->back()->with('error', $data['errors'][0]['detail']);
            }

            if (isset($data['data']['attributes']['redirect']['checkout_url'])) {
                return redirect($data['data']['attributes']['redirect']['checkout_url']);
            }

            return redirect()->back()->with('error', 'GCash payment failed.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function gcashSuccess(Request $request)
    {
        $lendingId = $request->get('lending_id');
        $paymentType = $request->get('payment_type', 'monthly'); // ADD THIS
        $loan = lending_program_tbl::findOrFail($lendingId);
        $status = lending_status_tbl::where('lending_id', $lendingId)->first();

        // Compute income breakdown per payment
        $interestRatio = ($loan->total_payment > 0) ? ($loan->total_interest / $loan->total_payment) : 0;

        $loanCalc = new \App\Services\LoanCalculationService;
        $currentInstallment = $loanCalc->currentInstallment($lendingId, true);

        if ($currentInstallment) {
            // ── SCHEDULE-BASED (new loans) ─────────────────────────────────────
            // FULL-INSTALLMENT-ONLY RULE (monthly): the required total is the
            // current installment amount_due plus any applicable 2% late fee
            // (same rule as the cash/admin paths). The late fee is booked
            // separately on the repayment record and is NEVER allocated into
            // the schedule (principal + interest = exact installment). Full
            // balance remains an existing allowed rule.
            $chargedAmount = round((float) $request->get('amount', 0), 2);
            $penaltyResult = $this->applicableLateFee($loan, $status, (float) $currentInstallment->amount_due);
            $lateFee = $penaltyResult['fee'];

            $installmentNumber = (int) $currentInstallment->payment_number;
            $installmentDueDate = $currentInstallment->due_date;

            if ($paymentType === 'full') {
                $cashReceived = $status ? (float) $status->remaining_balance : (float) $loan->total_payment;
                $installmentAmount = $cashReceived;
            } else {
                $cashReceived = $chargedAmount;

                $validation = $loanCalc->validateInstallmentPayment($lendingId, $cashReceived, $lateFee);
                if (! $validation['valid']) {
                    return redirect()->route('LoanStatus', ['loan_id' => $lendingId])
                        ->with('error', $validation['message']);
                }

                $installmentAmount = (float) $validation['amount_to_allocate'];
            }

            DB::transaction(function () use (
                $status, $loanCalc, $lendingId, $paymentType,
                $lateFee, $penaltyResult, $installmentAmount, $cashReceived,
                $installmentNumber, $installmentDueDate
            ) {
                // Apply the applicable overdue penalty (if any) atomically.
                if ($lateFee > 0 && $status && $penaltyResult['due_date']) {
                    $status->penalty_amount = (float) ($status->penalty_amount ?? 0) + $lateFee;
                    $status->remaining_balance = (float) $status->remaining_balance + $lateFee;
                    $status->last_penalty_date = $penaltyResult['due_date']->format('Y-m-d');
                }

                $allocation = $loanCalc->allocatePayment($lendingId, $installmentAmount);

                lending_repayments_tbl::create([
                    'lending_id' => $lendingId,
                    'user_id' => auth()->id(),
                    'payment_number' => $installmentNumber,
                    'amount_due' => $installmentAmount,
                    'amount_paid' => $installmentAmount,
                    'late_fee' => $lateFee,
                    'penalty_applied_at' => $lateFee > 0 ? now()->timezone('Asia/Manila') : null,
                    'principal_paid' => $allocation['principal_paid'],
                    'interest_paid' => $allocation['interest_paid'],
                    'service_fee_paid' => 0,
                    'due_date' => $installmentDueDate,
                    'payment_date' => now()->format('Y-m-d'),
                    'payment_method' => 'GCash',
                    'reference_no' => 'GCASH-'.now()->format('YmdHis'),
                    'payment_type' => $paymentType,
                    'notes' => $paymentType === 'full' ? 'Full balance repayment via GCash' : 'Paid via GCash',
                    'recorded_by' => null,
                ]);

                if ($status) {
                    $status->total_paid = round((float) $status->total_paid + (float) $allocation['amount_paid'], 2);
                    $status->remaining_balance = max(0, round((float) $status->remaining_balance - $cashReceived, 2));
                    $status->payments_made = (int) $status->payments_made + (int) $allocation['installments_settled'];

                    if ($allocation['fully_paid_now'] || $status->remaining_balance <= 0) {
                        $status->status = 'Completed';
                        $status->payments_made = $status->total_payments;
                        $status->remaining_balance = 0;
                        lending_program_tbl::where('id', $lendingId)->update(['status' => 'Completed']);
                    } else {
                        $nextUnpaid = $loanCalc->currentInstallment($lendingId);
                        if ($nextUnpaid) {
                            $status->due_date = $nextUnpaid->due_date;
                        }
                    }

                    $status->save();
                }
            });
        } elseif ($paymentType === 'full' && $status) {
            // ── FULL REPAYMENT ────────────────────────────────────────────
            $remainingBalance = $status->remaining_balance;
            $remainingPayments = $status->total_payments - $status->payments_made;

            // Create one repayment record per remaining payment
            for ($i = 1; $i <= $remainingPayments; $i++) {
                $paymentsMade = lending_repayments_tbl::where('lending_id', $lendingId)->count();
                $installmentAmount = $loan->monthly_payment;
                $interestPaid = round($installmentAmount * $interestRatio, 2);
                $principalPaid = round($installmentAmount - $interestPaid, 2);

                lending_repayments_tbl::create([
                    'lending_id' => $lendingId,
                    'user_id' => auth()->id(),
                    'payment_number' => $paymentsMade + 1,
                    'amount_paid' => $installmentAmount,
                    'principal_paid' => $principalPaid,
                    'interest_paid' => $interestPaid,
                    'service_fee_paid' => 0,
                    'payment_date' => now()->format('Y-m-d'),
                    'payment_method' => 'GCash',
                    'reference_no' => 'GCASH-FULL-'.now()->format('YmdHis').'-'.$i,
                    'payment_type' => 'full',
                    'notes' => 'Full balance repayment via GCash',
                    'recorded_by' => null,
                ]);
            }

            // Mark loan as fully paid
            $status->total_paid += $remainingBalance;
            $status->remaining_balance = 0;
            $status->payments_made = $status->total_payments;
            $status->status = 'Completed';
            $status->save();

            lending_program_tbl::where('id', $lendingId)->update(['status' => 'Completed']);

        } else {
            // ── SINGLE MONTHLY PAYMENT (existing logic) ───────────────────
            $paymentsMade = lending_repayments_tbl::where('lending_id', $lendingId)->count();
            $monthlyAmount = $loan->monthly_payment;
            $interestPaid = round($monthlyAmount * $interestRatio, 2);
            $principalPaid = round($monthlyAmount - $interestPaid, 2);

            lending_repayments_tbl::create([
                'lending_id' => $lendingId,
                'user_id' => auth()->id(),
                'payment_number' => $paymentsMade + 1,
                'amount_paid' => $monthlyAmount,
                'principal_paid' => $principalPaid,
                'interest_paid' => $interestPaid,
                'service_fee_paid' => 0,
'payment_date' => now()->format('Y-m-d'),
                'payment_method' => 'GCash',
                'reference_no' => 'GCASH-'.now()->format('YmdHis'),
                'payment_type' => 'monthly',
                'recorded_by' => null,
            ]);

            if ($status) {
                $status->total_paid += $loan->monthly_payment;
                $status->remaining_balance = max(0, $status->remaining_balance - $loan->monthly_payment);
                $status->payments_made += 1;
                $status->due_date = now()->addMonth()->format('Y-m-d');

                if ($status->remaining_balance <= 0 || $status->payments_made >= $status->total_payments) {
                    $status->status = 'Completed';
                    $status->payments_made = $status->total_payments;
                    lending_program_tbl::where('id', $lendingId)->update(['status' => 'Completed']);
                }

                $status->save();
            }
        }

        $paymentTypeLabel = $paymentType === 'full' ? 'Full balance repayment' : 'Monthly payment';
        AuditLog::log(
            'GCash Loan Repayment',
            "{$paymentTypeLabel} via GCash for loan #{$lendingId}".($paymentType === 'full' ? ' (loan completed)' : ''),
            'loan_repayment',
            $lendingId
        );

        return redirect()->route('LoanStatus', ['loan_id' => $lendingId])
            ->with('success', 'GCash payment successful!');
    }

    public function gcashFailed(Request $request)
    {
        $lendingId = $request->get('lending_id');

        return redirect()->route('LoanStatus', ['lending_id' => $lendingId])
            ->with('error', 'GCash payment failed. Please try again.');
    }

    /**
     * Compute the applicable 2% overdue penalty for a scheduled loan using the
     * SAME rule as the cash/admin repayment paths: once per missed due date,
     * guarded by last_penalty_date so it never stacks. Returns the fee (0 if
     * not applicable) and the due date it keys off (needed to record
     * last_penalty_date).
     *
     * @return array{fee:float, due_date:?\Carbon\CarbonInterface}
     */
    private function applicableLateFee($loan, $status, float $installmentAmount): array
    {
        if (! $status) {
            return ['fee' => 0.0, 'due_date' => null];
        }

        $nextDueDate = $status->due_date
            ? \Carbon\Carbon::parse($status->due_date)
            : \Carbon\Carbon::parse($loan->created_at)
                ->addDays(((int) $status->payments_made + 1) * \App\Services\LoanCalculationService::PAYMENT_INTERVAL_DAYS);

        $isOverdue = $nextDueDate->lt(now()->timezone('Asia/Manila'));
        $alreadyPenalized = $status->last_penalty_date
            && \Carbon\Carbon::parse($status->last_penalty_date)->gte($nextDueDate);

        return $isOverdue && ! $alreadyPenalized
            ? [
                'fee' => round($installmentAmount * (\App\Models\Loan_settings_tbl::getLateFeeRate($loan->lending_type) / 100), 2),
                'due_date' => $nextDueDate,
            ]
            : ['fee' => 0.0, 'due_date' => null];
    }
}
