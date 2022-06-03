<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReplyAnswerController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});

Route::get('/abc', function () {
    for($i = 2; $i <= 21; $i++) {
        $user = User::find($i);
        $profile = new \App\Models\Profile();
        $profile->user_id = $i;
        $profile->avatar = 'assets/avatar/img4.jpg';
        $profile->display_name = $user->username;
        $profile->save();
    }
});

Route::prefix('accounts')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('isLogged', [UserController::class, 'isLogged']);
    Route::post('sign-up', [UserController::class, 'signUp'])->name('user.signup');
    Route::post('sign-in', [UserController::class, 'signIn'])->name('user.signin');
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('log-out', [UserController::class, 'logOut'])->name('user.logout');
        Route::get('info', [UserController::class, 'getInfo'])->name('user.info');
        Route::post('profile_update', [UserController::class, 'updateProfile'])->name('user.update');
    });
    Route::get('info/{id}', [UserController::class, 'getInfoById'])->name('user.info.id');
    Route::post('reset-password', [ResetPasswordController::class, 'sendMail'])->name('password.reset');
    Route::post('reset-password/{token}', [ResetPasswordController::class, 'reset'])->name('user.reset');
    Route::get('getTimeMember/{id}', [UserController::class, 'getTimeMember'])->name('user.time');
    Route::post('send-token', [UserController::class, 'sendToken'])->name('user.login.sms');
    Route::post('login-with-token', [UserController::class, 'loginWithToken'])->name('user.login.token');
});

Route::group(['prefix' => 'questions'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('add', [QuestionController::class, 'store'])->name('question.add');
        Route::post('add_answer', [AnswerController::class, 'store'])->name('answer.add');
        Route::post('reply_answer', [ReplyAnswerController::class, 'store'])->name('reply.add');
        Route::post('choose_best_answer', [QuestionController::class, 'best_answer'])->name('question.best_answer');
        Route::get('find/{title}', [QuestionController::class, 'find_question'])->name('question.find');
    });
    Route::post('vote', [QuestionController::class, 'vote'])->name('question.vote');
    Route::post('answer_vote', [AnswerController::class, 'vote'])->name('answer.vote');
    Route::get('{slug}', [QuestionController::class, 'show'])->name('question.show');
    Route::get('/{size}/{page}', [QuestionController::class, 'index'])->name('question.list');
});

