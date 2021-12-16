<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReplyAnswerController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});

Route::prefix('accounts')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('isLogged', [UserController::class, 'isLogged']);
    Route::post('sign-up', [UserController::class, 'signUp'])->name('user.signup');
    Route::post('sign-in', [UserController::class, 'signIn'])->name('user.signin');
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('log-out', [UserController::class, 'logOut'])->name('user.logout')->middleware('auth:sanctum');
        Route::get('info', [UserController::class, 'getInfo'])->name('user.info');
        Route::post('profile_update', [UserController::class, 'updateProfile'])->name('user.update');
    });
    Route::get('info/{id}', [UserController::class, 'getInfoById'])->name('user.info.id');
    Route::post('reset-password', [ResetPasswordController::class, 'sendMail'])->name('user.reset-password');
    Route::post('reset-password/{token}', [ResetPasswordController::class, 'reset'])->name('user.reset');
    Route::get('getTimeMember/{id}', [UserController::class, 'getTimeMember'])->name('user.time');
});

Route::group(['prefix' => 'questions'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('add', [QuestionController::class, 'store'])->name('question.add');
        Route::post('add_answer', [AnswerController::class, 'store'])->name('answer.add');
        Route::post('reply_answer', [ReplyAnswerController::class, 'store'])->name('reply.add');
        Route::post('choose_best_answer', [QuestionController::class, 'best_answer'])->name('question.best_answer');
    });
    Route::post('vote', [QuestionController::class, 'vote'])->name('question.vote');
    Route::post('answer_vote', [AnswerController::class, 'vote'])->name('answer.vote');
    Route::get('{slug}', [QuestionController::class, 'show'])->name('question.show');
    Route::get('/{size}/{page}', [QuestionController::class, 'index'])->name('question.list');
});

