<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonobankController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');





Route::get('/', function () {
    return view('home.welcome');
});

Route::post('/user/tutorial', [UserIntroController::class, 'update'])->name('user.tutorial');


Route::prefix('auth')->group(function () {

    Route::get('login', [LoginController::class, 'index'])->name('login.index');
    Route::post('logout', [LoginController::class, 'logout'])->name('login.out');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');

    Route::get('reg', [RegisterController::class, 'index'])->name('reg.index');
    Route::post('store', [RegisterController::class, 'store'])->name('reg.store');

    Route::get('welcome', [WelcomeController::class, 'index'])->name('welcome');

    Route::get('monobank', [MonobankController::class, 'showClientInfo'])->name('monobank.index');

});

Route::prefix('category')->middleware('auth')->group(function () {

    Route::get('all', [CategoryController::class, 'index'])->name('category.index');
    Route::get('create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('store', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');
    Route::get('edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::patch('edit/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('show/{category}', [CategoryController::class, 'show'])->name('category.show');
   
});

Route::prefix('count')->middleware('auth')->group(function () {

    Route::get('all', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('create', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('store', [TransactionController::class, 'store'])->name('transaction.store');
    Route::delete('delete/{transaction}', [TransactionController::class, 'delete'])->name('transaction.delete');
    Route::get('edit/{transaction}', [TransactionController::class, 'edit'])->name('transaction.edit');
    Route::patch('edit/{transaction}', [TransactionController::class, 'update'])->name('transaction.update');
   
});

Route::prefix('report')->middleware('auth')->group(function () {
    Route::get('all', [ReportController::class, 'index'])->name('report.index');
});

Route::prefix('limits')->middleware('auth')->group(function () {
    Route::get('all', [CategoryController::class, 'limits'])->name('limits.index');
    Route::post('/category/{category}/update-limit', [CategoryController::class, 'updateLimits'])->name('limits.update');
});

Route::prefix('goals')->middleware('auth')->group(function () {
    Route::get('all', [GoalController::class, 'index'])->name('goals.index');

    Route::get('create', [GoalController::class, 'create'])->name('goals.create');
    Route::post('store', [GoalController::class, 'store'])->name('goals.store');

    Route::get('edit/{id}', [GoalController::class, 'edit'])->name('goals.edit');
    Route::patch('update/{id}', [GoalController::class, 'update'])->name('goals.update');

    Route::delete('delete/{id}', [GoalController::class, 'delete'])->name('goals.delete');

    Route::get('add/{id}', [GoalController::class, 'add'])->name('goals.add');
    Route::patch('add/{id}', [GoalController::class, 'addBalance'])->name('goals.added');
});

Route::prefix('financial')->middleware('auth')->group(function () {
    Route::get('/integrations', [IntegrationController::class, 'index'])->name('integrations.index');
    Route::post('/integrations', [IntegrationController::class, 'update'])->name('integrations.update');
});