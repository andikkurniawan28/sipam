<?php

use App\Http\Controllers\ApiHomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ResidentPaymentController;
use App\Http\Controllers\UserController;
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

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('home_api', ApiHomeController::class)->name('home_api');
Route::get('/', HomeController::class)->name('home')->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::get('user', [UserController::class, 'index'])
        ->name('user.index')
        ->middleware('role:IT');

    Route::get('user/create', [UserController::class, 'create'])
        ->name('user.create')
        ->middleware('role:IT');

    Route::post('user', [UserController::class, 'store'])
        ->name('user.store')
        ->middleware('role:IT');

    Route::get('user/{user}/edit', [UserController::class, 'edit'])
        ->name('user.edit')
        ->middleware('role:IT');

    Route::put('user/{user}', [UserController::class, 'update'])
        ->name('user.update')
        ->middleware('role:IT');

    Route::delete('user/{user}', [UserController::class, 'destroy'])
        ->name('user.destroy')
        ->middleware('role:IT');


    Route::get('resident', [ResidentController::class, 'index'])
        ->name('resident.index')
        ->middleware('role:IT, Ketua Paguyuban, Sekretaris Paguyuban');

    Route::get('resident/create', [ResidentController::class, 'create'])
        ->name('resident.create')
        ->middleware('role:IT, Ketua Paguyuban, Sekretaris Paguyuban');

    Route::post('resident', [ResidentController::class, 'store'])
        ->name('resident.store')
        ->middleware('role:IT, Ketua Paguyuban, Sekretaris Paguyuban');

    Route::get('resident/{resident}/edit', [ResidentController::class, 'edit'])
        ->name('resident.edit')
        ->middleware('role:IT, Ketua Paguyuban, Sekretaris Paguyuban');

    Route::put('resident/{resident}', [ResidentController::class, 'update'])
        ->name('resident.update')
        ->middleware('role:IT, Ketua Paguyuban, Sekretaris Paguyuban');

    Route::delete('resident/{resident}', [ResidentController::class, 'destroy'])
        ->name('resident.destroy')
        ->middleware('role:IT, Ketua Paguyuban, Sekretaris Paguyuban');


    Route::get('gateway', [GatewayController::class, 'index'])
        ->name('gateway.index')
        ->middleware('role:IT, Ketua Paguyuban, Bendahara Paguyuban');

    Route::get('gateway/create', [GatewayController::class, 'create'])
        ->name('gateway.create')
        ->middleware('role:IT, Ketua Paguyuban, Bendahara Paguyuban');

    Route::post('gateway', [GatewayController::class, 'store'])
        ->name('gateway.store')
        ->middleware('role:IT, Ketua Paguyuban, Bendahara Paguyuban');

    Route::get('gateway/{gateway}/edit', [GatewayController::class, 'edit'])
        ->name('gateway.edit')
        ->middleware('role:IT, Ketua Paguyuban, Bendahara Paguyuban');

    Route::put('gateway/{gateway}', [GatewayController::class, 'update'])
        ->name('gateway.update')
        ->middleware('role:IT, Ketua Paguyuban, Bendahara Paguyuban');

    Route::delete('gateway/{gateway}', [GatewayController::class, 'destroy'])
        ->name('gateway.destroy')
        ->middleware('role:IT, Ketua Paguyuban, Bendahara Paguyuban');


    Route::get('payment', [PaymentController::class, 'index'])
        ->name('payment.index')
        ->middleware('role:IT, Ketua Paguyuban, Bendahara Paguyuban, PJ Air & Sampah, Admin Air & Sampah');

    Route::get('payment/create', [PaymentController::class, 'create'])
        ->name('payment.create')
        ->middleware('role:IT, PJ Air & Sampah, Admin Air & Sampah');

    Route::post('payment', [PaymentController::class, 'store'])
        ->name('payment.store')
        ->middleware('role:IT, PJ Air & Sampah, Admin Air & Sampah');

    Route::delete('payment/{payment}', [PaymentController::class, 'destroy'])
        ->name('payment.destroy')
        ->middleware('role:IT, Bendahara Paguyuban');

    Route::get('payment/{payment}', [PaymentController::class, 'show'])
        ->name('payment.show')
        ->middleware('role:IT, PJ Air & Sampah, Admin Air & Sampah');

    Route::get('resident_payment', [ResidentPaymentController::class, 'index'])
        ->name('resident_payment.index')
        ->middleware('role:IT, PJ Air & Sampah, Admin Air & Sampah, Ketua Paguyuban, Bendahara Paguyuban, Sekretaris Paguyuban');

    Route::post('resident_payment', [ResidentPaymentController::class, 'process'])
        ->name('resident_payment.process')
        ->middleware('role:IT, PJ Air & Sampah, Admin Air & Sampah, Ketua Paguyuban, Bendahara Paguyuban, Sekretaris Paguyuban');
});
