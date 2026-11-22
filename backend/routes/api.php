<?php

use App\Http\Controllers\AccessRoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginBrandingController;
use App\Http\Middleware\AuthenticateAccessToken;
use App\Http\Middleware\ProtectBrowserAuth;
use Illuminate\Support\Facades\Route;

Route::get('login/branding', [LoginBrandingController::class, 'show']);

Route::middleware(ProtectBrowserAuth::class)->group(function (): void {
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:auth-login');
    Route::post('login/refresh', [AuthController::class, 'refresh'])->middleware('throttle:auth-session');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('throttle:auth-session');
    Route::post('password/forgot', [AuthController::class, 'forgotPassword'])->middleware('throttle:auth-recovery');
    Route::post('password/reset', [AuthController::class, 'resetPassword'])->middleware('throttle:auth-recovery');
});

Route::middleware(AuthenticateAccessToken::class)->group(function (): void {
    Route::get('me', [AuthController::class, 'me']);
    Route::prefix('access')->middleware('can:manage-access')->group(function (): void {
        Route::get('catalog', [AccessRoleController::class, 'catalog']);
        Route::get('roles', [AccessRoleController::class, 'index']);
        Route::post('roles', [AccessRoleController::class, 'store']);
        Route::put('roles/{role}', [AccessRoleController::class, 'update'])->whereNumber('role');
        Route::put('users/{user}/role', [AccessRoleController::class, 'assign'])->whereNumber('user');
    });

    Route::get('perfil', [AuthController::class, 'profile']);
    Route::post('perfil', [AuthController::class, 'updateProfile'])->middleware('throttle:auth-sensitive');
    Route::post('perfil/contrasena', [AuthController::class, 'updatePassword'])->middleware('throttle:auth-sensitive');
});
