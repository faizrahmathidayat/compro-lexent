<?php

use App\Http\Controllers\CmsController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Lexent static company profile routes. Every route is resolved through
| PageController - no view is called directly from here.
|
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/products', [PageController::class, 'products'])->name('products.index');
Route::get('/products/{slug}', [PageController::class, 'productDetail'])->name('products.show');
Route::get('/paint-protection-film', [PageController::class, 'ppfIndex'])->name('ppf.index');
Route::get('/paint-protection-film/{slug}', [PageController::class, 'ppfDetail'])->name('ppf.show');
Route::get('/dealers', [PageController::class, 'dealers'])->name('dealers');
Route::get('/cek-garansi', [PageController::class, 'cekGaransi'])->name('cek-garansi');
Route::get('/artikel', [CmsController::class, 'articles'])->name('articles.index');
Route::get('/artikel/{slug}', [CmsController::class, 'articleShow'])->name('articles.show');
