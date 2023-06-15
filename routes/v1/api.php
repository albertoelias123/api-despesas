<?php

use Illuminate\Http\Request;
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

Route::post('login',[UserController::class,'loginUser'])->name('login');

Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[UserController::class,'userDetails']);
    Route::get('logout',[UserController::class,'revokeAllTokens']);

    //Route::apiResource('despesas', DespesasController::class);
});
