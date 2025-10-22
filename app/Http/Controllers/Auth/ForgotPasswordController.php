<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password-simple');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'This email address does not exist in our system.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            Log::info('Password reset link sent successfully', [
                'email' => $request->email,
                'status' => $status
            ]);
            
            return back()->with('status', '✅ Password reset link sent successfully! Please check your email inbox and spam folder.');
        } else {
            Log::error('Failed to send password reset link', [
                'email' => $request->email,
                'status' => $status
            ]);
            
            return back()->withErrors(['email' => '❌ Unable to send reset link. Please try again.']);
        }
    }
}
