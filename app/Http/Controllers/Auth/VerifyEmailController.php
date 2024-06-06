<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectAfterVerification($request->user()->role);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectAfterVerification($request->user()->role);
    }

    /**
     * Redirect the user to their respective dashboard after email verification.
     */
    protected function redirectAfterVerification(string $role): RedirectResponse
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('verified', true);
            case 'supplier':
                return redirect()->route('supplier.dashboard')->with('verified', true);
            case 'customer':
                return redirect()->route('dashboard')->with('verified', true);
            default:
                return redirect()->intended(RouteServiceProvider::HOME)->with('verified', true);
        }
    }
}
