<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/', ['App\Http\Controllers\Frontend\HomeController', 'index'])->name('home');
Route::get('/blog', ['App\Http\Controllers\Frontend\BlogController', 'index'])->name('blog');
Route::get('/blog/{id}/details', ['App\Http\Controllers\Frontend\BlogController', 'details'])->name('blog_details');

Route::group(['prefix'=>'backend', 'middleware'=>['can:isAdmin'] , 'as'=>'backend.'], function() {
    Route::get('/', ['App\Http\Controllers\Backend\DashboardController', 'index'])->name('dashboard');
    // Route::group(['prefix'=>'products','as'=>'products.'],function() {
    //   Route::get('/', [ProductsController::class, 'list'])->name('list');
    //   Route::get('/create', [ProductsController::class, 'create'])->name('create');
    //   Route::post('/create', [ProductsController::class, 'store'])->name('store');
    //   Route::post('/{id}/update', [ProductsController::class, 'update'])->name('update');
    //   Route::get('/{id}/edit', [ProductsController::class, 'edit'])->name('edit');
    //   Route::post('/upload-images', [ProductsController::class, 'uploadImages'])->name('upload_images');
    // });
});
