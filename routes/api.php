<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('accounts')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('sign-up', [\App\Http\Controllers\UserController::class, 'signUp'])->name('user.signup');
    Route::post('sign-in', [\App\Http\Controllers\UserController::class, 'signIn'])->name('user.signin');
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('log-out', [\App\Http\Controllers\UserController::class, 'logOut'])->name('user.logout')->middleware('auth:sanctum');
        Route::get('info', [\App\Http\Controllers\UserController::class, 'getInfo'])->name('user.info');
    });
});

Route::group(['prefix' => 'questions', 'middleware' => 'auth:sanctum'], function () {
   Route::post('add', [\App\Http\Controllers\QuestionController::class, 'store'])->name('question.add');
   Route::get('/', [\App\Http\Controllers\QuestionController::class, 'index'])->name('question.list');
});
   Route::get('a', [\App\Http\Controllers\QuestionController::class, 'index'])->name('question.list');

