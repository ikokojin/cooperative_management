<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\lendingController;
use App\Http\Controllers\ShareCapital;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersHandle;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\DividendController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AlliedWorkerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get("/", [UserController::class, "UserDirection"]);

Route::get("/index", [UserController::class, "index"])->name("index");

// ✅ THIS IS THE KEY FIX - named 'login' must point to the login PAGE view
Route::get("/login", [UserController::class, "LoginPage"])->name("login");

// Login page also accessible via /login-page
Route::get("/login-page", [UserController::class, "LoginPage"])->name("LoginPage");

// Login Handle page POST only
Route::post("/login-handle", [UsersHandle::class, "login"])->name("UserLogin");

// Register page GET
Route::get("/register-page", [UserController::class, "RegisterPage"])->name("RegisterPage");

// About us page GET
Route::get("/about-us", [UserController::class, "AboutUs"])->name("AboutUs");

// Services page GET
Route::get("/services", [UserController::class, "ServicesPage"])->name("ServicesPage");

// Blogs page GET
Route::get("/blogs", [UserController::class, "BlogsPage"])->name("BlogsPage");

// Contact page GET
Route::get("/contact", [UserController::class, "ContactPage"])->name("ContactPage");

Route::get("/navbar", [UserController::class, "Navbar"]);

// Static page GET
Route::get("/static-page", [UserController::class, "StaticPage"])->name("StaticPage");

Route::post('/check-email', [UsersHandle::class, 'checkEmail'])->name('check.email');

// Member Portal page GET
Route::get("/member-portal", [UsersHandle::class, "MemberPortal"])->name("MemberPortal")->middleware("auth");

// Lending Program page GET
Route::get("/loan_application", [lendingController::class, "index"])->name("LoanApplication");

Route::post('/savings/{id}/update-status', [UserController::class, 'updateSavingsStatus'])->name('savings.updateStatus');
Route::post('/savings/{id}/disburse', [UserController::class, 'disburseSavingsWithdrawal'])->name('savings.disburse');
Route::post('/savings/{id}/complete-deposit', [UserController::class, 'completeSavingsDeposit'])->name('savings.complete-deposit');
Route::post('/savings/{id}/void-deposit', [UserController::class, 'voidSavingsDeposit'])->name('savings.void-deposit');

// Route::get("/savings", [UsersHandle::class, "Savings"])->name("savings");

// Savings routes
Route::get("/savings-page", [SavingsController::class, "index"])->name("savings.index")->middleware("auth");

Route::post("/savings/deposit", [SavingsController::class, "deposit"])->name("savings.deposit")->middleware("auth");

Route::post("/savings/withdraw", [SavingsController::class, "withdraw"])->name("savings.withdraw")->middleware("auth");


// Share Capital page GET
Route::get('/share-capital', [ShareCapital::class, 'memberIndex'])
    ->name("ShareCapitalMember")
    ->middleware('auth');

// Profile Member page GET
Route::get("/profile-member", [UsersHandle::class, "ProfileMember"])->name("ProfileMember");

// Edit Profile Member page GET
Route::get("/edit-profile-member", [UsersHandle::class, "EditProfileMember"])->name("EditProfileMember");

// Edit Profile Member page POST
Route::post("/edit-profile-member", [UsersHandle::class, "UpdateProfileMember"])->name("UpdateProfileMember");

Route::get("/settings", [UsersHandle::class, "Settings"])->name("Settings");

Route::get("/notifications", [UsersHandle::class, "Notifications"])->name("Notifications");

Route::post('/settings/toggle', [App\Http\Controllers\UsersHandle::class, 'UpdateSetting'])->name('settings.toggle');
Route::post('/settings/change-password', [App\Http\Controllers\UsersHandle::class, 'ChangePassword'])->name('settings.changePassword');
Route::post('/settings/request-deactivation', [App\Http\Controllers\UsersHandle::class, 'RequestDeactivation'])->name('settings.requestDeactivation');
Route::get('/settings/export', [App\Http\Controllers\UsersHandle::class, 'ExportData'])->name('settings.export');

Route::get('/savings', [SavingsController::class, 'index'])->name('savings.index');

Route::get("/Seminars", [UsersHandle::class, "Seminars"])->name("Seminars");

Route::post("/seminars/verify-passcode", [UsersHandle::class, "verifySeminarPasscode"])->name("Seminars.verifyPasscode");

Route::post('/notifications/mark-all-read', [App\Http\Controllers\UsersHandle::class, 'MarkAllRead'])
    ->name('notifications.markAllRead');

Route::get('/member-portal', [UsersHandle::class, 'MemberPortal'])->name('MemberPortal');

Route::get("/transactions", [UsersHandle::class, "Transactions"])->name("transactions");

// Driver Portal page GET
Route::get("/driver-portal", [UserController::class, "DriverPortal"])->name("DriverPortal");

// User Handle page GET
Route::get("/user-handle", [UsersHandle::class, "UserHandle"])->name("UserHandle")->middleware("auth");

// Registration page POST
Route::post("/registration", [UsersHandle::class, "registration"])->name("registration");

Route::get('/approve-user/{id}', [UserController::class, 'approveUser'])->name('approve.user');

Route::get('/messageAboutShare/{id}', [UserController::class, "messageAboutShare"])->name("message.user");

Route::middleware(['auth'])->group(function () {
    Route::get('/share-capital-form', [ShareCapital::class, 'index'])->name('share_capital.index');
    Route::post('/share-capital-form', [ShareCapital::class, 'store'])->name('share_capital.store');

});

Route::post('/loan-disburse', [lendingController::class, 'disburseLoan'])->name('loan.disburse');

Route::post('/admin/loans/apply-penalties', [lendingController::class, 'adminApplyOverduePenalties'])
    ->name('admin.loans.applyPenalties');

Route::post('/share-capital/store', [ShareCapital::class, 'store'])->name('share_capital.store');
Route::post('/share-capital/store', [ShareCapital::class, 'store'])->name('share_capital.store.admin');

// Share Capital form via email link
Route::get('/share-capital-form/{id}', [ShareCapital::class, 'showForMember'])->name('share_capital.show');

// GCash routes for Share Capital
Route::post('/share-capital/gcash', [ShareCapital::class, 'payViaGcash'])->name('share_capital.gcash');
Route::get('/share-capital/gcash/success', [ShareCapital::class, 'gcashSuccess'])->name('share_capital.gcash.success');
Route::get('/share-capital/gcash/failed', [ShareCapital::class, 'gcashFailed'])->name('share_capital.gcash.failed');

// Application form
Route::get('/application-form/{id}', [UserController::class, 'applicationForm'])->name('applicationForm');

Route::post('/application-form/{id}', [UsersHandle::class, 'applicationFormButton'])->name('applicationFormButton');

Route::get("/nav-bar2", [UsersHandle::class, "Navbar2"])->name("Navbar2");

Route::get("/logout", [UsersHandle::class, "logout"])->name("logout");

Route::post("/lending-program", [lendingController::class, "lendingProgram"])
    ->name("lendingProgram")
    ->middleware("auth");

Route::get("/Financial", [UsersHandle::class, "Financial"])->name("Financial");

Route::get('/check-reference', [UsersHandle::class, 'checkReference'])
    ->name('reference.check')
    ->middleware('auth');

Route::get('/savings/receipt/{referenceNo}', [SavingsController::class, 'downloadReceipt'])
    ->name('savings.receipt');

Route::post('/savings/admin/store', [SavingsController::class, 'adminStoreSavings'])
    ->name('savings.admin.store')
    ->middleware('auth');

Route::get('/savings/admin/balance/{memberId}', [SavingsController::class, 'getMemberBalance'])
    ->name('savings.admin.balance')
    ->middleware('auth');

Route::get('/savings/admin/sc-balance/{memberId}', [SavingsController::class, 'getMemberShareCapitalBalance'])
    ->name('savings.admin.sc-balance')
    ->middleware('auth');

Route::post('/savings/convert-to-share-capital', [SavingsController::class, 'convertToShareCapital'])
    ->name('savings.convert-to-share-capital')
    ->middleware('auth');

Route::post('/savings/gcash', [SavingsController::class, 'payViaGcash'])->name('savings.gcash');
Route::get('/savings/gcash/success', [SavingsController::class, 'gcashSuccess'])->name('savings.gcash.success');
Route::get('/savings/gcash/failed', [SavingsController::class, 'gcashFailed'])->name('savings.gcash.failed');

Route::get('/loan-status', [lendingController::class, 'loanStatus'])
    ->name('LoanStatus')
    ->middleware('auth');

Route::post('/repayment/store', [lendingController::class, 'storeRepayment'])
    ->name('repayment.store')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::post('/repayment/gcash', [PaymentController::class, 'payViaGcash'])->name('repayment.gcash');
    Route::get('/repayment/gcash/success', [PaymentController::class, 'gcashSuccess'])->name('repayment.gcash.success');
    Route::get('/repayment/gcash/failed', [PaymentController::class, 'gcashFailed'])->name('repayment.gcash.failed');
});

// ✅ Final — just these two lines, no wrapping group needed
Route::post('/otp/send', [OtpController::class, 'send'])->name('otp.send');
Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');

// ✅ With web middleware — session persists correctly
// Route::middleware('web')->group(function () {
//     Route::post('/send-otp', [OtpController::class, 'send'])->name('send.otp');
//     Route::post('/verify-otp', [OtpController::class, 'verify'])->name('verify.otp');
// });

// Admin routes
Route::get("/dashboard-admin", [UserController::class, "dashboard_admin"])->name("dashboard");
Route::get("/dashboard-members", [UserController::class, "dashboard_members"])->name("dashboard.members");
Route::put("/dashboard-members/update", [UserController::class, "updateMember"])->name("update.member");
Route::post("/dashboard-members/store", [UserController::class, "storeMember"])->name("member.store");
Route::get("/dashboard-members/send-share-email/{id}", [UserController::class, "sendShareCapitalEmail"])->name("send.share.capital.email");
Route::delete("/dashboard-members/decline/{id}", [UserController::class, "declineUser"])->name("decline.user");
Route::redirect("/dashboard-savings", "/dashboard-financial-activity?tab=savings")->name("savings");
Route::get("/dashboard-lendings", [UserController::class, "dashboard_lendings"])->name("lendings");

// API to get payment count for a loan
Route::get('/loan/{id}/payments-count', function ($id) {
    $count = \DB::table('lending_repayments_tbls')->where('lending_id', $id)->count();
    return response()->json(['payments_made' => $count]);
});
Route::post("/loan/approve/{id}", [UserController::class, "approveLoan"])->name("loan.approve");
Route::post("/loan/decline/{id}", [UserController::class, "declineLoan"])->name("loan.decline");
Route::post("/loan/create-admin", [UserController::class, "createLoanAdmin"])->name("loan.create-admin");
Route::post("/loan/settings/update", [UserController::class, "updateLoanSettings"])->name("loan.settings.update");
Route::redirect("/dashboard-sharecapitals", "/dashboard-financial-activity?tab=share-capitals")->name("sharecapitals");
Route::post("/sharecapital/admin/store", [UserController::class, "adminStoreShareCapital"])->name("sharecapital.admin.store");
Route::get("/sharecapital/member/{id}/balance", [UserController::class, "getMemberShareCapitalBalance"])->name("sharecapital.member.balance");
Route::post("/sharecapital/withdrawal/{id}/status", [UserController::class, "updateWithdrawalStatus"])->name("sharecapital.withdrawal.status");
Route::post("/sharecapital/{id}/complete-deposit", [UserController::class, 'completeShareCapitalDeposit'])->name('sharecapital.complete-deposit');
Route::post("/sharecapital/{id}/void-deposit", [UserController::class, 'voidShareCapitalDeposit'])->name('sharecapital.void-deposit');
Route::post("/sharecapital/sell", [ShareCapital::class, "sellShares"])->name("sharecapital.sell");
Route::get("/dashboard-reports", [ReportController::class, "index"])->name("reports");
Route::get("/dashboard-reports/daily", [ReportController::class, "daily"])->name("reports.daily");
Route::get("/dashboard-reports/journal-detailed", [ReportController::class, "journalDetailed"])->name("reports.journal.detailed");
Route::get("/dashboard-reports/journal-summary", [ReportController::class, "journalSummary"])->name("reports.journal.summary");
Route::get("/dashboard-reports/statement-of-operations", [ReportController::class, "statementOfOperations"])->name("reports.statement");
Route::get("/dashboard-reports/statement-of-operations/print", [ReportController::class, "statementOfOperationsPrint"])->name("reports.statement.print");
Route::get("/dashboard-settings", [UserController::class, "dashboard_settings"])->name("settings")->middleware("auth");
Route::post("/dashboard-settings", [UserController::class, "dashboard_settings"])->name("settings.update")->middleware("auth");
Route::post("/admin/store", [UserController::class, "storeAdmin"])->name("admin.store");
Route::post("/admin/change-password", [UserController::class, "changePassword"])->name("admin.change-password")->middleware("auth");
Route::post("/admin/update", [UserController::class, "updateAdmin"])->name("admin.update");
Route::post("/admin/delete", [UserController::class, "deleteAdmin"])->name("admin.delete");
Route::post("/admin/toggle-status", [UserController::class, "toggleAdminStatus"])->name("admin.toggle-status");
Route::post("/roles/store", [UserController::class, "storeRole"])->name("roles.store");
Route::post("/roles/update", [UserController::class, "updateRole"])->name("roles.update");
Route::post("/roles/delete", [UserController::class, "deleteRole"])->name("roles.delete");

// Allied Worker management (GM / Main Admin only; guards enforced in controller)
Route::get("/allied-workers", [AlliedWorkerController::class, "index"])->name("allied-workers.index")->middleware("auth");
Route::post("/allied-workers/promote", [AlliedWorkerController::class, "promote"])->name("allied-workers.promote")->middleware("auth");
Route::post("/allied-workers/revoke", [AlliedWorkerController::class, "revoke"])->name("allied-workers.revoke")->middleware("auth");
Route::post("/allied-workers/switch-to-member", [AlliedWorkerController::class, "switchToMember"])->name("allied-workers.switch-to-member")->middleware("auth");
Route::post("/allied-workers/switch-to-aw", [AlliedWorkerController::class, "switchToAw"])->name("allied-workers.switch-to-aw")->middleware("auth");
// archives route removed
Route::match(["get", "post"], "/dashboard-financial-activity", [UserController::class, "dashboard_financial_activity"])->name("financial.activity");
Route::post('/loan-settings/create', [UserController::class, 'createLoanSetting'])->name('loan.settings.create');
Route::post('/loan-settings/update', [UserController::class, 'updateLoanSettings'])->name('loan.settings.update');
Route::delete('/loan-settings/{id}', [UserController::class, 'deleteLoanSetting'])->name('loan.settings.delete');

Route::get("/loan-stats", [UsersHandle::class, "loanStats"])->name("loan_stats");

Route::post("/cooperative-transactions/store", [UserController::class, "storeCooperativeTransaction"])->name("cooperative.transactions.store");
Route::get("/dashboard-payments", [UserController::class, "dashboard_payments"])->name("payments")->middleware("auth");
Route::post("/dashboard-payments/record", [UserController::class, "adminStoreRepayment"])->name("payments.record");
Route::post('/repayments/{id}/complete', [UserController::class, 'completeRepayment'])->name('repayment.complete');
Route::post('/repayments/{id}/void', [UserController::class, 'voidRepayment'])->name('repayment.void');
Route::get("/loans/member/{id}/active", function ($id) {
    $loans = \App\Models\lending_program_tbl::where('user_id', $id)
        ->whereIn('status', ['Approved'])
        ->select('id', 'reference_no', 'lending_type', 'monthly_payment', 'total_payment', 'lending_amount')
        ->get();
    return response()->json($loans);
})->name("loans.member.active");
Route::get('/loans/{id}/payable', [App\Http\Controllers\UserController::class, 'getLoanPayable'])->name('loans.payable');
Route::get("/admin/audit-logs", [UserController::class, "auditLogsIndex"])->name("admin.audit-logs.index");
Route::get("/dashboard-officers-committees", [UserController::class, "dashboard_officers_committees"])->name("officers.committees");
Route::post("/officers/store", [UserController::class, "storeOfficer"])->name("officers.store");
Route::put("/officers/{id}", [UserController::class, "updateOfficer"])->name("officers.update");
Route::delete("/officers/{id}", [UserController::class, "deleteOfficer"])->name("officers.delete");
// Announcement routes
Route::post("/announcements", [App\Http\Controllers\AnnouncementController::class, "store"])->name("announcements.store");
Route::post("/announcements/{id}/comment", [App\Http\Controllers\AnnouncementController::class, "storeComment"])->name("announcements.comment");
Route::post("/announcements/{id}/like", [App\Http\Controllers\AnnouncementController::class, "toggleLike"])->name("announcements.like");
Route::post("/announcements/{id}/comment/{commentId}/delete", [App\Http\Controllers\AnnouncementController::class, "deleteComment"])->name("announcements.comment.delete");
Route::post("/announcements/{id}/delete", [App\Http\Controllers\AnnouncementController::class, "deleteAnnouncement"])->name("announcements.delete");

// Poll routes
Route::post("/polls", [App\Http\Controllers\AnnouncementController::class, "storePoll"])->name("announcements.poll.store");
Route::post("/polls/{pollId}/vote", [App\Http\Controllers\AnnouncementController::class, "votePoll"])->name("announcements.poll.vote");
Route::post("/polls/{pollId}/delete", [App\Http\Controllers\AnnouncementController::class, "deletePoll"])->name("announcements.poll.delete");

// Seminar routes
Route::get("/admin/seminars", [App\Http\Controllers\SeminarController::class, "index"])->name("seminars.index");
Route::post("/admin/seminars/schedule", [App\Http\Controllers\SeminarController::class, "scheduleSeminar"])->name("seminars.schedule");
Route::post("/admin/seminars/attendance", [App\Http\Controllers\SeminarController::class, "updateAttendanceAndCompletion"])->name("seminars.attendance");
Route::post("/admin/seminars/store-type", [App\Http\Controllers\SeminarController::class, "storeSeminarType"])->name("seminars.store-type");
Route::get("/admin/seminars/member-search", [App\Http\Controllers\SeminarController::class, "memberSearch"])->name("seminars.member-search");

// Resignation routes
Route::post("/member/resign", [App\Http\Controllers\ResignationController::class, "requestResignation"])->name("resignation.request")->middleware("auth");
Route::post("/admin/resignation/{id}/approve", [App\Http\Controllers\ResignationController::class, "approveResignation"])->name("resignation.approve");
Route::post("/admin/resignation/{id}/reject", [App\Http\Controllers\ResignationController::class, "rejectResignation"])->name("resignation.reject");
Route::post("/admin/resignation/{id}/release", [App\Http\Controllers\ResignationController::class, "releaseShareCapital"])->name("resignation.release");

// Dividend routes
Route::get("/admin/dividends", [DividendController::class, "index"])->name("dividends.index");
Route::get("/admin/dividends/partial", [DividendController::class, "tablePartial"])->name("dividends.table-partial");
Route::post("/admin/dividends/calculate", [DividendController::class, "calculate"])->name("dividends.calculate");
Route::put("/admin/dividends/{id}/update", [DividendController::class, "update"])->name("dividends.update");
Route::post("/admin/dividends/{id}/approve", [DividendController::class, "approve"])->name("dividends.approve");
Route::post("/admin/dividends/{id}/disburse", [DividendController::class, "disburseOne"])->name("dividends.disburse-one");
Route::post("/admin/dividends/disburse", [DividendController::class, "disburseAll"])->name("dividends.disburse");
Route::post("/admin/dividends/disburse-all/{year}", [DividendController::class, "disburseAll"])->name("dividends.disburse-all");
Route::post("/admin/dividends/fund-percentage", [DividendController::class, "updateFundPercentage"])->name("dividends.update-fund-percentage");

// Patronage Refund Distribution routes
Route::get("/admin/dividends/patronage-partial", [DividendController::class, "patronageTablePartial"])->name("dividends.patronage-partial");
Route::get("/admin/dividends/calculate-patronage", [DividendController::class, "calculatePatronageRefunds"])->name("dividends.calculate-patronage");
Route::get("/admin/dividends/reset/{year}", [DividendController::class, "resetDistribution"])->name("dividends.reset");
Route::put("/admin/dividends/patronage/{id}/update", [DividendController::class, "updatePatronageRefund"])->name("dividends.patronage.update");
Route::post("/admin/dividends/patronage/{id}/approve", [DividendController::class, "approvePatronageRefund"])->name("dividends.patronage.approve");
Route::post("/admin/dividends/patronage/approve-all", [DividendController::class, "approveAllPatronageRefunds"])->name("dividends.patronage.approve-all");
Route::post("/admin/dividends/patronage/{id}/disburse", [DividendController::class, "disbursePatronageRefundOne"])->name("dividends.patronage.disburse-one");
Route::post("/admin/dividends/patronage/disburse-all/{year?}", [DividendController::class, "disburseAllPatronageRefunds"])->name("dividends.patronage.disburse-all");
Route::post("/admin/dividends/disburse-both/{year?}", [DividendController::class, "disburseBoth"])->name("dividends.disburse-both");
Route::get("/admin/dividends/patronage/{id}/breakdown", [DividendController::class, "patronageBreakdown"])->name("dividends.patronage.breakdown");
Route::post("/admin/dividends/update-patronage-basis", [DividendController::class, "updatePatronageBasis"])->name("dividends.update-patronage-basis");

// Additional Patronage Records routes
Route::get("/patronage-records/partial", [UserController::class, "patronageRecordsPartial"])->name("patronage-records.partial");
Route::post("/patronage-records", [UserController::class, "storePatronageRecord"])->name("patronage-records.store");
Route::put("/patronage-records/{id}", [UserController::class, "updatePatronageRecord"])->name("patronage-records.update");
Route::delete("/patronage-records/{id}", [UserController::class, "deletePatronageRecord"])->name("patronage-records.delete");

// ═══════════════════════════════════════════════════
//  DEBUG — view all database tables & records
//  Only accessible when APP_ENV=local && APP_DEBUG=true
// ═══════════════════════════════════════════════════
if (config('app.env') === 'local' && config('app.debug')) {
    Route::get('/debug-db', function () {
        $tables = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . env('DB_DATABASE');
        $output = '';

        foreach ($tables as $table) {
            $tableName = $table->$key;
            $count = DB::table($tableName)->count();
            $columns = DB::select("SHOW FULL COLUMNS FROM `{$tableName}`");

            $output .= "<h2 style='margin-top:2rem;'>{$tableName} <span style='font-size:14px;color:#666;'>({$count} rows)</span></h2>";

            // Schema table
            $output .= "<table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;width:100%;margin-bottom:8px;font-size:13px;'>";
            $output .= "<tr style='background:#f0f0f0;'><th>#</th><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
            foreach ($columns as $i => $col) {
                $output .= "<tr>
                    <td>" . ($i + 1) . "</td>
                    <td><strong>{$col->Field}</strong></td>
                    <td>{$col->Type}</td>
                    <td>{$col->Null}</td>
                    <td>{$col->Key}</td>
                    <td>" . ($col->Default ?? '<em>NULL</em>') . "</td>
                    <td>{$col->Extra}</td>
                </tr>";
            }
            $output .= "</table>";

            // Data table
            if ($count > 0) {
                $rows = DB::table($tableName)->limit(100)->get();
                $cols = array_keys((array) $rows[0]);

                $output .= "<table border='1' cellpadding='4' cellspacing='0' style='border-collapse:collapse;width:100%;font-size:12px;'>";
                $output .= "<tr style='background:#e8e8e8;'>";
                foreach ($cols as $c) {
                    $output .= "<th>{$c}</th>";
                }
                $output .= "</tr>";

                foreach ($rows as $row) {
                    $output .= "<tr>";
                    foreach ($cols as $c) {
                        $val = $row->$c ?? '';
                        if ($val === '' || $val === null) {
                            $output .= "<td style='color:#aaa;'><em>NULL</em></td>";
                        } else {
                            $output .= "<td>" . htmlspecialchars((string) $val) . "</td>";
                        }
                    }
                    $output .= "</tr>";
                }
                if ($count > 100) {
                    $output .= "<tr><td colspan='" . count($cols) . "' style='text-align:center;color:#999;'>... only showing 100 of {$count} rows</td></tr>";
                }
                $output .= "</table>";
            } else {
                $output .= "<p style='color:#999;'><em>Table is empty</em></p>";
            }
        }

        return "<!DOCTYPE html><html><head><title>DB Debug</title>
            <style>body{font-family:monospace;padding:20px;background:#fafafa;}
            h1{color:#333;}table{background:#fff;margin-bottom:1rem;}
            th{text-align:left;white-space:nowrap;}td{max-width:400px;overflow:hidden;text-overflow:ellipsis;}
            tr:nth-child(even){background:#f8f8f8;}
            a{color:#06c;text-decoration:none;margin-right:12px;}
            .tools{padding:8px 0;}</style></head><body>
            <h1>🔍 Database Debug</h1>
            <div class='tools'>
                <a href='/debug-db'>All Tables</a>
                <span style='color:#999;'>" . count($tables) . " tables</span>
            </div>
            {$output}
            </body></html>";
    });

    // Payment Method routes
    Route::get('/admin/payment-methods', [App\Http\Controllers\PaymentMethodController::class, 'index'])->name('payment-methods.index');
    Route::post('/admin/payment-methods', [App\Http\Controllers\PaymentMethodController::class, 'store'])->name('payment-methods.store');
    Route::put('/admin/payment-methods/{id}', [App\Http\Controllers\PaymentMethodController::class, 'update'])->name('payment-methods.update');
    Route::delete('/admin/payment-methods/{id}', [App\Http\Controllers\PaymentMethodController::class, 'destroy'])->name('payment-methods.delete');
    Route::post('/admin/payment-methods/{id}/toggle', [App\Http\Controllers\PaymentMethodController::class, 'toggleActive'])->name('payment-methods.toggle');
    Route::get('/admin/payment-methods/{id}/qr', [App\Http\Controllers\PaymentMethodController::class, 'getQrCode'])->name('payment-methods.qr');
}
