<?php

use App\Http\Controllers\DespesaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes v1
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return response()->json(['message' => 'Hello World!'], 200);
});

Route::post('login', [UserController::class,'loginUser'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user', [UserController::class,'authUserDetails'])->name('authUser');
    Route::get('logout', [UserController::class,'revokeAllTokens'])->name('logout');

    Route::apiResources([
        'despesas' => DespesaController::class
    ]);
});
