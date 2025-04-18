<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('home');
});

// Registration Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');


Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::middleware(['auth'])->group(function () {

    Route::resource('books', BookController::class);
    Route::resource('authors', AuthorController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])
     ->name('books.reviews.store');

    Route::get('/review/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::patch('/review/{review}', [ReviewController::class, 'update']) ->name('reviews.update');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});






