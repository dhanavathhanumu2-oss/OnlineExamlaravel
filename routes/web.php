<?php

use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ExamController::class, 'home'])->name('home');
Route::get('/start', [ExamController::class, 'start'])->name('start');
Route::post('/submit', [ExamController::class, 'submit'])->name('submit');
Route::get('/result', [ExamController::class, 'result'])->name('result');
Route::post('/reload-questions', [ExamController::class, 'reloadQuestions'])->name('reload');
