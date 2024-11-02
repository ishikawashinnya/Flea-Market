<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

//AuthenticationRoutes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('store.register');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('store.login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/', [MarketController::class, 'index'])->name('home');

//AuthenticatedUserRoutes
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [MarketController::class, 'mypage'])->name('mypage');

    Route::post('/likes', [MarketController::class, 'likeCreate'])->name('likes.create');
    Route::delete('/likes/{id}', [MarketController::class, 'likeDestroy'])->name('likes.destroy');
});