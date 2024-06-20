<?php
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Profile\PasswordController;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/verify_user_email', [AuthController::class, 'verifyUserEmail']);
Route::post('auth/resend_email_verifcation_link', [AuthController::class, 'resendEmailVerificatioLink']);
Route::middleware(['auth'])->group(function(){
Route::post('/change_password',[PasswordController::class,'ChangeUserPassword'] );
Route::post('auth/logout', [AuthController::class, 'logout']);
});
