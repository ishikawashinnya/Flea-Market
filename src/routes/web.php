<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
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
Route::get('item/{item_id}', [MarketController::class, 'detail'])->name('detail');
Route::get('selleritem/{user_id}', [MarketController::class, 'sellerItem'])->name('selleritem');

//AuthenticatedUserRoutes
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [MarketController::class, 'mypage'])->name('mypage');
    Route::get('/mypage/profile', [MarketController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [MarketController::class, 'updateProfile'])->name('update.profile');

    Route::post('/like', [MarketController::class, 'storeLike'])->name('store.like');
    Route::delete('/like/{id}', [MarketController::class, 'destroyLike'])->name('destroy.like');

    Route::get('/purchase/address/{item_id}', [MarketController::class, 'editAddress'])->name('edit.address');
    Route::post('address/update', [MarketController::class, 'updateAddress'])->name('update.address');
    Route::get('/purchase/method/{item_id}', [MarketController::class, 'editPaymentMethod'])->name('edit.method');
    Route::post('method/update', [MarketController::class, 'updatePaymentMethod'])->name('update.method');

    Route::get('/sell', [MarketController::class, 'sell'])->name('sell');
    Route::post('/sell/store', [MarketController::class, 'storeSell'])->name('store.sell');
    Route::get('/sell/{id}/edit', [MarketController::class, 'editSell'])->name('edit.sell');
    Route::post('/sell/{id}', [MarketController::class, 'updateSell'])->name('update.sell');

    Route::get('/comment/{item_id}', [MarketController::class, 'comment'])->name('comment');
    Route::post('/comment/store/{item_id}', [MarketController::class, 'storeComment'])->name('store.comment');
    Route::delete('/comment/{comment_id}',[MarketController::class, 'destroyComment'])->name('destroy.comment');

    Route::get('/purchase/{item_id}', [MarketController::class, 'buy'])->name('buy');
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    Route::get('/purchase/success/{item_id}', [PaymentController::class, 'success'])->name('success');
    Route::get('/purchase/cancel/{item_id}', [PaymentController::class, 'cancel'])->name('cancel');
    Route::post('/purchase/banktransfer', [PaymentController::class, 'banktransfer'])->name('banktransfer');
});

//AdminRoute
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
    Route::get('/userlist', [AdminController::class, 'getUsers'])->name('userlist');
    Route::delete('/userlist/{user_id}',[AdminController::class, 'destroyUser'])->name('destroy.user');
    Route::get('/commentlist', [AdminController::class, 'getComments'])->name('commentlist');
    Route::delete('/commentlist/{comment_id}',[AdminController::class, 'destroyComment'])->name('destroy.comment');
    Route::get('/mailform', [AdminController::class, 'mailform'])->name('mailform');
    Route::post('/mail/send', [AdminController::class, 'sendMail'])->name('send.mail');
});