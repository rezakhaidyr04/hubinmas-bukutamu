<?php

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

use App\Http\Controllers\GuestbookController;
use App\Http\Controllers\AdminController;

Route::get('/', [GuestbookController::class, 'welcome'])->name('guestbook.welcome');
Route::get('/form', [GuestbookController::class, 'showForm'])->name('guestbook.form');
Route::post('/guestbook/submit', [GuestbookController::class, 'submitForm'])->name('guestbook.submit');
Route::get('/guestbook/success', [GuestbookController::class, 'showSuccess'])->name('guestbook.success');

// Admin Auth Routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/forgot-pin', [AdminController::class, 'forgotPin'])->name('admin.forgot_pin');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Protected Admin Routes
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::delete('/admin/visit/{id}', [AdminController::class, 'destroy'])->name('admin.visit.destroy');
});
