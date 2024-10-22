<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model

// Middleware for authenticated users
Route::middleware('auth')->group(function () {

    // Check if the user is authenticated and verified
    /** @var User $user */
    $user = Auth::user();

    if ($user && $user->hasVerifiedEmail()) {
        return redirect()->route('dashboard'); // Redirect to the dashboard or another route
    }

    // Show the email verification notice
    Route::get('/email/verify', function () {
        /** @var User $user */
        $user = Auth::user();
        if ($user && $user->hasVerifiedEmail()) {
            return redirect()->route('dashboard'); // Redirect to the dashboard or another route
        }
        return view('auth.verify-email'); // Blade view for verification prompt
    })->name('verification.notice');

    // Resend email verification link
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');

    // Handle email verification logic
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); // Mark email as verified

        return redirect()->route('dashboard')->with('message', 'Email verified successfully!');
    })->middleware(['signed'])->name('verification.verify');
});
