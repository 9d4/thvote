<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VerifiedController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth:web')->group(function () {
    // ALL
    Route::get('/', [FrontController::class, 'index'])->name('index');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // ONLY USERS
    //Route::group(['middleware' => 'user', 'prefix' => '/'], function () {
        //Route::post('vote', [VoteController::class, 'doVote'])->name('post.vote');
    //});

    // ADMINS
    Route::group([
        'middleware' => 'admin',
        'prefix' => 'dash'
    ], function () {
        Route::get('/', [DashController::class, 'dashboard'])->name('admin.dash');
        Route::get('/verified-users', [DashController::class, 'showVerifiedUsers'])->name('admin.verifiedUsers');
        Route::post('/remove-verified-user', [VerifiedController::class, 'removeVerifiedUser'])->name('admin.removeVerifiedUser');
        Route::post('/add-verified-user', [VerifiedController::class, 'addVerifiedUser'])->name('admin.addVerifiedUser');

        Route::post('/verify-vote', [VoteController::class, 'verifyVote'])->name('admin.verifyVote');

        Route::get('leaders', [CandidateController::class, 'showCandidates'])->name('admin.leaders');
        Route::post('new-leader', [CandidateController::class, 'addNewCandidate'])->name('admin.newLeader');
        Route::post('delete-candidate/{id}', [CandidateController::class, 'deleteCandidate'])->name('admin.deleteCandidate');

        Route::get('co-leaders', [CandidateController::class, 'showCandidates'])->name('admin.coLeaders');
        Route::post('new-co-leaders', [CandidateController::class, 'addNewCandidate'])->name('admin.newCoLeader');

        Route::get('result', [VoteController::class, 'showResult'])->name('admin.result');

        Route::post('change-banner', [DashController::class, 'changeBanner'])->name('admin.post.changeBanner');
        Route::post('change-deadline', [DashController::class, 'changeDeadline'])->name('admin.post.changeDeadline');
        Route::post('start-vote', [VoteController::class, 'startVote'])->name('admin.post.startVote');
        Route::post('pause-vote', [VoteController::class, 'pauseVote'])->name('admin.post.pauseVote');
        Route::post('stop-vote', [VoteController::class, 'stopVote'])->name('admin.post.stopVote');
        Route::post('reset-vote', [VoteController::class, 'resetVote'])->name('admin.post.resetVote');

        /*DANGER*/
//        Route::get('/init/meta/init', [DashController::class, 'initMeta']);
    });
});


Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('unauthorized');

Route::get('/register', function () {
    return view('register');
})->name('register')->middleware('unauthorized');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('debug', [DashController::class, 'debug']);
