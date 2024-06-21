<?php
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Profile\PasswordController;
use App\Http\Controllers\Api\Profile\PasswordResetController;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/verify_user_email', [AuthController::class, 'verifyUserEmail']);
Route::post('auth/resend_email_verifcation_link', [AuthController::class, 'resendEmailVerificatioLink']);
Route::post('password/reset', [PasswordController::class, 'resetPassword']);

Route::post('password/forgot', [PasswordResetController::class, 'sendResetLink']);

Route::post('password/reset/password', [PasswordResetController::class, 'resetPassword']);

Route::middleware(['auth'])->group(function(){
Route::post('/change_password',[PasswordController::class,'ChangeUserPassword'] );
Route::post('auth/logout', [AuthController::class, 'logout']);



});
