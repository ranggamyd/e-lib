<?php

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

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\BookController;
use App\Http\Controllers\admin\LoanController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\WaqfController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\AuthorController;
use App\Http\Controllers\admin\MemberController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\ReturnController;
use App\Http\Controllers\admin\SearchController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\WaqfBookController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\PublisherController;
use App\Http\Controllers\admin\CollectionController;
use App\Http\Controllers\admin\CardTemplateController;

// ======================================== MEMBER AREA ======================================== //
Route::get('/{url}', [App\Http\Controllers\frontend\HomeController::class, 'index'])->where(['url' => '|home']);
Route::get('/books', [App\Http\Controllers\frontend\BookController::class, 'index']);
Route::get('/books/{id}', [App\Http\Controllers\frontend\BookController::class, 'show']);
Route::get('/collections', [App\Http\Controllers\frontend\CollectionController::class, 'index']);
Route::get('/collections/{id}', [App\Http\Controllers\frontend\CollectionController::class, 'show']);
Route::get('/categories', [App\Http\Controllers\frontend\CategoryController::class, 'index']);
Route::get('/categories/{id}', [App\Http\Controllers\frontend\CategoryController::class, 'show']);
Route::get('/authors', [App\Http\Controllers\frontend\AuthorController::class, 'index']);
Route::get('/authors/{id}', [App\Http\Controllers\frontend\AuthorController::class, 'show']);
Route::get('/publishers', [App\Http\Controllers\frontend\PublisherController::class, 'index']);
Route::get('/publishers/{id}', [App\Http\Controllers\frontend\PublisherController::class, 'show']);

Route::middleware(['member'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\frontend\ProfileController::class, 'index']);
    Route::resource('/transactions/orders', App\Http\Controllers\frontend\OrderController::class);
    Route::get('/transactions/loans', [App\Http\Controllers\frontend\LoanController::class, 'index']);
    Route::get('/transactions/returns', [App\Http\Controllers\frontend\LoanController::class, 'return']);
    Route::resource('/transactions/waqfs', App\Http\Controllers\frontend\WaqfController::class);
});

// ======================================== AUTH AREA ======================================== //
Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('login');;
Route::post('/login_process', [AuthController::class, 'login_process']);
Route::get('/logout', [AuthController::class, 'logout']);

// ======================================== ADMIN AREA ======================================== //
Route::middleware(['admin'])->group(function () {
    Route::get('/admin{url}', [DashboardController::class, 'index'])->where(['url' => '|/dashboard']);
    Route::resource('/admin/transactions/orders', OrderController::class);
    Route::get('/admin/transactions/orders/accept/{id}', [OrderController::class, 'accept']);
    Route::get('/admin/transactions/orders/reject/{id}', [OrderController::class, 'reject']);
    Route::get('/admin/transactions/orders/destroyAll/{id}', [OrderController::class, 'destroyAll']);
    Route::resource('/admin/transactions/loans', LoanController::class);
    Route::get('/admin/transactions/loans/return/{id}', [LoanController::class, 'return']);
    Route::get('/admin/transactions/loans/destroyAll/{id}', [LoanController::class, 'destroyAll']);
    Route::resource('/admin/transactions/returns', ReturnController::class);
    Route::resource('/admin/transactions/waqfs', WaqfController::class);
    Route::get('/admin/transactions/waqfs/accept/{id}', [WaqfController::class, 'accept']);
    Route::get('/admin/transactions/waqfs/reject/{id}', [WaqfController::class, 'reject']);
    Route::get('/admin/transactions/waqfs/destroyAll/{id}', [WaqfController::class, 'destroyAll']);

    Route::resource('/admin/books', BookController::class);
    // Route::resource('/admin/waqfBooks', WaqfBookController::class);
    Route::resource('/admin/collections', CollectionController::class);
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/authors', AuthorController::class);
    Route::resource('/admin/publishers', PublisherController::class);
    Route::resource('/admin/cardTemplates', CardTemplateController::class);

    Route::get('/admin/reports/all', [ReportController::class, 'index']);
    Route::get('/admin/reports/loans', [ReportController::class, 'loans']);
    Route::get('/admin/reports/returns', [ReportController::class, 'returns']);
    Route::get('/admin/reports/waqfs', [ReportController::class, 'waqfs']);

    Route::resource('/admin/members', MemberController::class);
    Route::get('/admin/members/print/{id}', [MemberController::class, 'print']);
    Route::resource('/admin/users', UserController::class);

    Route::get('/admin/profile', [ProfileController::class, 'index']);

    route::get('/admin/search', [SearchController::class, 'search'])->name('adminSearch');
});
