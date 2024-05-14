<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Modules\FileManager\App\Http\Controllers\Api\v1\FileController;

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

/**--------------------------------------------------------------------------------
 * File manager Controller  => START
 * --------------------------------------------------------------------------------*/

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:api', 'scope:'.User::ROLE_ADMIN])->group(function () {
        Route::prefix('admin/filemanager/files')->group(function () {
            Route::get('/', [FileController::class, 'index']);
            Route::get('{id}', [FileController::class, 'show']);
            Route::put('{file}', [FileController::class, 'update']);
            Route::post('uploads', [FileController::class, 'adminUploads']);
            Route::delete('{file}', [FileController::class, 'destroy']);
        });
        Route::prefix('admin/filemanager')->group(function () {
            Route::get('/', [FileController::class, 'index']);
            Route::post('uploads', [FileController::class, 'adminUploads']);
        });
    });

    Route::prefix('filemanager/files')->group(function () {
        Route::delete('{file}', [FileController::class, 'destroy']);
        Route::post('uploads', [FileController::class, 'frontUpload']);
    });
});
/**--------------------------------------------------------------------------------
 * File manager Controller => END
 * --------------------------------------------------------------------------------*/
