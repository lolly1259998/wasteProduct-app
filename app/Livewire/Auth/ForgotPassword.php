<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.minimal')]
class ForgotPassword extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $status = Password::sendResetLink($this->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', '✅ Password reset link sent successfully! Please check your email inbox and spam folder.');
            $this->email = ''; // Clear the email field after successful send
        } else {
            $this->addError('email', '❌ Unable to send reset link. Please check your email address and try again.');
        }
    }
}
