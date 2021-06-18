<?php

use App\Http\Controllers\Admin\Catalog\ProductController;
use App\Http\Controllers\Admin\MainPageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Catalog\CartController;
use App\Http\Controllers\Catalog\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\PagesController;


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

# Patterns #

Route::pattern('code', '[a-zA-Z0-9-/_]+');
Route::pattern('id', '[0-9]+');

Route::get('/test/', [CatalogController::class, 'test']);

# Catalog #
Route::get('/catalog/{code}', [CatalogController::class, 'index']);

Route::get('/cart/', [CartController::class, 'index'])->name('cart');

Route::get('/order/', [OrderController::class, 'createOrderPage'])->name('makeOrder');
Route::post('/order/', [OrderController::class, 'create']);


# Personal #

Route::group(['prefix' => 'profile', 'middleware' => 'auth', 'as' => 'profile.'], function() {
   Route::get('/', [ProfileController::class, 'index'])->name('index');

   Route::get('/personal/', [ProfileController::class, 'user'])->name('user');
   Route::post('/personal/', [ProfileController::class, 'updateUser']);

   Route::get('/orders/',[ProfileController::class, 'orders'])->name('orders');
   Route::get('/orders/{id}/', [ProfileController::class, 'order']);

   Route::delete('/orders/{id}', [ProfileController::class, 'cancelOrder']);

});

# Auth #

Route::group(['prefix' => 'auth'], function() {
    Route::get('/login/', [LoginController::class, 'index'])->name('login');
    Route::post('/login/', [LoginController::class, 'login']);

    Route::post('/logout/', [LogoutController::class, 'index'])->name('logout');
});

Route::post('/logout/', [LogoutController::class, 'index'])->name('logout');


# AJAX Cart #

Route::group(['prefix' => 'api/cart'], function() {
    
    Route::get('/', [CartController::class, 'ajaxGetCart']);
    Route::put('/', [CartController::class, 'ajaxAddProduct']);
    Route::delete('/', [CartController::class, 'ajaxDeleteProduct']);
});


# Admin #

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.'], function() {

   Route::get('/', [MainPageController::class, 'index'])->name('index');

   # Товар #
   
   Route::group(['prefix' => 'product', 'as' => 'product.'], function() {

        Route::get('/create/', [ProductController::class, 'createPage'])->name('create');
        Route::post('/create/', [ProductController::class, 'create']);

        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/{id}/', [ProductController::class, 'editPage'])->name('editPage');

        Route::post('/{id}/edit', [ProductController::class, 'edit']);
        Route::post('/{id}/softdelete', [ProductController::class, 'softDelete']);
        Route::post('/{id}/unsoftdelete', [ProductController::class, 'unSoftDelete']);
        Route::delete('/{id}/delete', [ProductController::class, 'delete']);

        Route::post('{id}/image/add', [ProductController::class, 'addImages']);
        Route::post('/{id}/image/changemain', [ProductController::class, 'changeMainImage']);
        Route::delete('/{id}/image/delete',[ProductController::class, 'deleteImage']);


   });

   Route::get('/category/', [\App\Http\Controllers\Admin\Catalog\CategoryController::class, 'index'])->name('category');

   Route::get('/routes/', [\App\Http\Controllers\Admin\RoutesController::class, 'index'])->name('routes');


});
