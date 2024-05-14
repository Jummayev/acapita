<?php

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

use App\Models\User;
use Modules\Translation\App\Http\Controllers\TranslationController;

Route::prefix('v1')->group(function () {
    Route::prefix('admin/translations')->group(function () {
        Route::middleware(['auth:api', 'scope:'.User::ROLE_ADMIN])->group(function () {
            Route::get('/', [TranslationController::class, 'adminIndex']);
            Route::get('{id}', [TranslationController::class, 'show'])->whereNumber('id');
            Route::put('/', [TranslationController::class, 'update']);
        });

    });
    Route::prefix('translations')->group(function () {
        Route::post('/{language}', [TranslationController::class, 'store']);
        Route::get('/', [TranslationController::class, 'clientIndex']);
        Route::get('{id}', [TranslationController::class, 'show'])->whereNumber('id');
    });
});
