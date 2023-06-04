<?php

use App\Http\Controllers\Question\{LikeController, PublishController, UnlikeController};
use App\Http\Controllers\{DashboardController, ProfileController, QuestionController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    if (app()->isLocal()) {
        auth()->loginUsingId(1);

        return to_route('dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //Rotes Question
    Route::get('question', [QuestionController::class, 'index'])->name('question.index');
    Route::post('question/store', [QuestionController::class, 'store'])->name('question.store');
    Route::get('question/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
    Route::delete('question/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');
    Route::post('question/like/{question}', LikeController::class)->name('question.like');
    Route::post('question/unlike/{question}', UnlikeController::class)->name('question.unlike');
    Route::put('question/{question}', PublishController::class)->name('question.publish');

    //Rotes Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
