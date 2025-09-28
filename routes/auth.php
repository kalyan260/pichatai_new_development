<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\Sms\TwilioSmsController;
use App\Http\Controllers\Auth\Social\FacebookController;
use App\Http\Controllers\Auth\Social\GithubController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\Social\GoogleController;
use App\Http\Controllers\Auth\Social\LinkedinController;
use App\Http\Controllers\Auth\Social\TwitterController;
use App\Http\Controllers\Auth\Social\InstagramController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware(['guest','XssSanitizerExcludable:password,password_confirmation']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware(['guest','XssSanitizer'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware(['guest','XssSanitizer:password,password_confirmation'])->name('password.update');
Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])->middleware('auth')->name('verification.notice');
Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['auth', 'otherAccountCheck', 'signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->middleware('auth')->name('password.confirm');
Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])->middleware('auth');
Route::any('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// Social Login Comes Here
Route::prefix('social/auth')->name('social.auth.')->group(function () {
    Route::prefix('google')->name('google.')->group(function () {
        Route::get('/',[GoogleController::class,'index'])->name('index');
        Route::any('/callback',[GoogleController::class,'callback'])->name('callback');
    });
    Route::prefix('facebook')->name('facebook.')->group(function () {
        Route::get('/',[FacebookController::class,'index'])->name('index');
        Route::any('/callback',[FacebookController::class,'callback'])->name('callback');
    });
    Route::prefix('github')->name('github.')->group(function () {
        Route::get('/',[GithubController::class,'index'])->name('index');
        Route::any('/callback',[GithubController::class,'callback'])->name('callback');
    });
    Route::prefix('twitter')->name('twitter.')->group(function () {
        Route::get('/',[TwitterController::class,'index'])->name('index');
        Route::any('/callback',[TwitterController::class,'callback'])->name('callback');
    });
    Route::prefix('linkedin')->name('linkedin.')->group(function () {
        Route::get('/',[LinkedinController::class,'index'])->name('index');
        Route::any('/callback',[LinkedinController::class,'callback'])->name('callback');
    });
    Route::prefix('instagram')->name('instagram.')->group(function () {
        Route::get('/',[InstagramController::class,'index'])->name('index');
        Route::any('/callback',[InstagramController::class,'callback'])->name('callback');
    });
});

// Custom Verification Check
Route::get('/verify-phone-number',[TwilioSmsController::class,'index'])->middleware('auth')->name('verify-phone-number');
Route::post('/verify-phone-number',[TwilioSmsController::class,'send'])->middleware('auth');
Route::post('/verify-otp',[TwilioSmsController::class,'verifyOtp'])->middleware('auth')->name('verify-otp');
