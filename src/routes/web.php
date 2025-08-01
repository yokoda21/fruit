<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SeasonController;
use Illuminate\Support\Facades\Route;


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

// トップページ - 商品一覧にリダイレクト
Route::get('/', function () {
    return redirect()->route('products.index');
});

// 商品一覧画面
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品検索機能
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

// 商品登録画面表示
Route::get('/products/register', [ProductController::class, 'register'])->name('products.register');

// 商品登録処理
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

// 商品詳細画面
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// 商品更新画面表示
Route::get('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');

// 商品更新処理
Route::put('/products/{product}/update', [ProductController::class, 'updateStore'])->name('products.update.store');

// 商品削除処理
Route::delete('/products/{product}/delete', [ProductController::class, 'delete'])->name('products.delete');

// 季節管理
Route::resource('seasons', SeasonController::class);
