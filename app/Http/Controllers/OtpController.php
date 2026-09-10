<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    public function send(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;
        $otp = random_int(100000, 999999);

        Session::put('email_otp', $otp);
        Session::put('email_otp_email', $email);
        Session::put('email_otp_expires', now()->addMinutes(5));

        try {
            Mail::raw(
                "Your verification code is: $otp\n\nThis code expires in 5 minutes.",
                function ($msg) use ($email) {
                    $msg->to($email)->subject('Email Verification Code');
                }
            );
        } catch (\Exception $e) {
            Log::error('OTP mail failed: '.$e->getMessage());

            return response()->json([
                'sent' => false,
                'message' => 'Failed to send email. Please check your mail configuration.',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }

        try {
            AuditLog::log(
                'Sent OTP',
                "Sent OTP verification email to {$email}",
                'otp',
                null
            );
        } catch (\Exception $e) {
            Log::error('AuditLog failed (non-fatal): '.$e->getMessage());
        }

        return response()->json(['sent' => true]);
    }

    public function verify(Request $request)
    {
        $otp = Session::get('email_otp');
        $email = Session::get('email_otp_email');
        $expires = Session::get('email_otp_expires');

        if (! $otp || ! $expires) {
            return response()->json(['valid' => false, 'message' => 'OTP expired. Please request a new one.']);
        }

        if (now()->gt($expires)) {
            Session::forget(['email_otp', 'email_otp_email', 'email_otp_expires']);

            return response()->json(['valid' => false, 'message' => 'OTP has expired. Please request a new one.']);
        }

        if ((string) $request->otp !== (string) $otp || $request->email !== $email) {
            return response()->json(['valid' => false, 'message' => 'Incorrect code. Please try again.']);
        }

        Session::forget(['email_otp', 'email_otp_email', 'email_otp_expires']);
        Session::put('email_otp_verified_email', $request->email);

        // ✅ FIX: wrap in try/catch, same as send().
        // Previously this was unguarded — if AuditLog::log() threw for any
        // reason (DB issue, model constraint, etc.), Laravel returned a 500
        // HTML error page instead of our JSON response. The frontend's
        // res.json() then failed to parse that HTML, landed in its catch
        // block, and showed "Verification failed. Please try again." —
        // even though the OTP itself was correct and had already been
        // verified successfully above.
        try {
            AuditLog::log(
                'Verified OTP',
                "OTP verified for email {$request->email}",
                'otp',
                null
            );
        } catch (\Exception $e) {
            Log::error('AuditLog failed (non-fatal): '.$e->getMessage());
        }

        return response()->json(['valid' => true]);
    }
}
