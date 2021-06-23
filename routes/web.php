<?php

use App\Http\Controllers\Admin\MainPageController;
use App\Http\Controllers\Admin\Page\PageCreateController;
use App\Http\Controllers\Admin\Page\PageEditController;
use App\Http\Controllers\Admin\Product\ProductCreateController;
use App\Http\Controllers\Admin\Product\ProductEditController;
use App\Http\Controllers\Admin\Product\ProductImageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Catalog\CartController;
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\Catalog\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
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

Route::group(['prefix' => 'profile', 'middleware' => 'auth', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');

    Route::get('/personal/', [ProfileController::class, 'user'])->name('user');
    Route::post('/personal/', [ProfileController::class, 'updateUser']);

    Route::get('/orders/', [ProfileController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}/', [ProfileController::class, 'order']);

    Route::delete('/orders/{id}', [ProfileController::class, 'cancelOrder']);

});

# Auth #

Route::group(['prefix' => 'auth'], function () {
    Route::get('/login/', [LoginController::class, 'index'])->name('login');
    Route::post('/login/', [LoginController::class, 'login']);

    Route::post('/logout/', [LogoutController::class, 'index'])->name('logout');
});

Route::post('/logout/', [LogoutController::class, 'index'])->name('logout');

# AJAX Cart #

Route::group(['prefix' => 'api/cart'], function () {

    Route::get('/', [CartController::class, 'ajaxGetCart']);
    Route::put('/', [CartController::class, 'ajaxAddProduct']);
    Route::delete('/', [CartController::class, 'ajaxDeleteProduct']);
});

# Admin #

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.'], function () {

    Route::get('/', [MainPageController::class, 'index'])->name('index');

    # Товар #

    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {

        Route::get('/', [ProductEditController::class, 'index'])->name('index');

        Route::get('/edit/{id}', [ProductEditController::class, 'editPage']);
        Route::post('/edit', [ProductEditController::class, 'edit'])->name('edit');

        Route::post('/deactivate', [ProductEditController::class, 'deactivate'])->name('deactivate');
        Route::post('/activate', [ProductEditController::class, 'activate'])->name('activate');

        Route::delete('/delete', [ProductEditController::class, 'delete'])->name('delete');

        Route::get('/create/', [ProductCreateController::class, 'index'])->name('create');
        Route::post('/create/', [ProductCreateController::class, 'create']);

        Route::group(['prefix' => 'image', 'as' => 'image.'], function () {

            Route::post('/add', [ProductImageController::class, 'add'])->name('add');
            Route::post('/changemain', [ProductImageController::class, 'changeMain'])->name('changeMain');
            Route::delete('/delete', [ProductImageController::class, 'delete'])->name('delete');
        });

    });

    # Статичные страницы #

    Route::group(['prefix' => 'page', 'as' => 'page.'], function () {

        Route::get('/create', [PageCreateController::class, 'index'])->name('create');
        Route::post('/create', [PageCreateController::class, 'create']);


        Route::get('/edit', [PageEditController::class, 'select'])->name('select');
        Route::get('/edit/{id}', [PageEditController::class, 'index'])->name('index');
    
        Route::post('/edit', [PageEditController::class, 'edit'])->name('edit');

        Route::post('/deactivate', [PageEditController::class, 'deactivate'])->name('deactivate');
        Route::post('/activate', [PageEditController::class, 'activate'])->name('activate');

        Route::delete('/delete', [PageEditController::class, 'delete'])->name('delete');
        
    });

    Route::get('/category/', [\App\Http\Controllers\Admin\Catalog\CategoryController::class, 'index'])->name('category');

    Route::get('/routes/', [\App\Http\Controllers\Admin\RoutesController::class, 'index'])->name('routes');

});


# Static pages #


foreach(require('pages.php') as $code) {
    Route::get('/' . $code,  [PageController::class, 'index']);
}