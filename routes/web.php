<?php

use App\Http\Controllers\Admin\Category\CategorySelectController;
use App\Http\Controllers\Admin\Category\CategoryUpdateController;
use App\Http\Controllers\Admin\Category\CateogryCreateController;
use App\Http\Controllers\Admin\Menu\MenuCreateController;
use App\Http\Controllers\Admin\Menu\MenuSelectController;
use App\Http\Controllers\Admin\Menu\MenuUpdateController;
use App\Http\Controllers\Admin\Order\OrderSelectController;
use App\Http\Controllers\Admin\Order\OrderUpdateController;
use App\Http\Controllers\Admin\Page\PageCreateController;
use App\Http\Controllers\Admin\Page\PageSelectController;
use App\Http\Controllers\Admin\Page\PageUpdateController;
use App\Http\Controllers\Admin\Product\ProductCreateController;
use App\Http\Controllers\Admin\Product\ProductImageController;
use App\Http\Controllers\Admin\Product\ProductSelectController;
use App\Http\Controllers\Admin\Product\ProductUpdateController;
use App\Http\Controllers\Admin\Role\RoleCreateController;
use App\Http\Controllers\Admin\Role\RoleSelectController;
use App\Http\Controllers\Admin\Role\RoleUpdateController;
use App\Http\Controllers\Admin\Store\StoreCreateController;
use App\Http\Controllers\Admin\Store\StoreSelectController;
use App\Http\Controllers\Admin\Store\StoreUpdateController;
use App\Http\Controllers\Admin\User\UserCreateController;
use App\Http\Controllers\Admin\User\UserSelectController;
use App\Http\Controllers\Admin\User\UserUpdateController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CatalogController;
use App\Http\Controllers\Shop\OrderController;
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Shop\SearchController;
use App\Services\PageService;
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
Route::get('/', [PageController::class, 'mainPage']);
Route::get('/catalog/{code}', [CatalogController::class, 'index']);
Route::get('/search/', [SearchController::class, 'index'])->name('search');

Route::get('/cart/', [CartController::class, 'index'])->name('cart');

Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::post('/', [OrderController::class, 'create']);

    Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('success');
});


# Personal #

Route::group(['prefix' => 'profile', 'middleware' => 'auth', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');

    Route::get('/personal/', [ProfileController::class, 'user'])->name('user');

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

Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', function() { return view('admin.index'); })->name('index');

    # Товар #

    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {

        Route::get('/', [ProductSelectController::class, 'index'])->name('select');

        Route::get('/update/{id}', [ProductUpdateController::class, 'index'])->name('update');
        Route::post('/update/{id}', [ProductUpdateController::class, 'update']);

        Route::post('/deactivate', [ProductUpdateController::class, 'deactivate'])->name('deactivate');
        Route::post('/activate', [ProductUpdateController::class, 'activate'])->name('activate');

        Route::post('/stores/{id}', [ProductUpdateController::class, 'stores'])->name('stores');

        Route::delete('/delete', [ProductUpdateController::class, 'delete'])->name('delete');

        Route::get('/create/', [ProductCreateController::class, 'index'])->name('create');
        Route::post('/create/', [ProductCreateController::class, 'create']);


        Route::group(['prefix' => 'image', 'as' => 'image.'], function () {

            Route::post('/add', [ProductImageController::class, 'add'])->name('add');
            Route::post('/changemain', [ProductImageController::class, 'changeMain'])->name('changeMain');
            Route::delete('/delete', [ProductImageController::class, 'delete'])->name('delete');
        });

    });


    # Категория #

    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('/', [CategorySelectController::class, 'index'])->name('select');

        Route::get('/{id}', [CategoryUpdateController::class, 'index'])->name('update');
        Route::post('/{id}', [CategoryUpdateController::class, 'update']);
        Route::delete('/{id}', [CategoryUpdateController::class, 'delete']);

        Route::post('/deactivate', [CategoryUpdateController::class, 'deactivate'])->name('deactivate');
        Route::post('/activate', [CategoryUpdateController::class, 'activate'])->name('activate');
        Route::delete('/image_delete', [CategoryUpdateController::class, 'image_delete'])->name('image_delete');

        Route::get('/create', [CateogryCreateController::class,'index'])->name('create');
        Route::post('/create', [CateogryCreateController::class,'create']);


    });

    # Статичные страницы #

    Route::group(['prefix' => 'page', 'as' => 'page.'], function () {

        Route::get('/create', [PageCreateController::class, 'index'])->name('create');
        Route::post('/create', [PageCreateController::class, 'create']);


        Route::get('/', [PageSelectController::class, 'index'])->name('select');


        Route::get('/{id}', [PageUpdateController::class, 'index'])->name('update');
        Route::post('/{id}', [PageUpdateController::class, 'update']);

        Route::post('/deactivate', [PageUpdateController::class, 'deactivate'])->name('deactivate');
        Route::post('/activate', [PageUpdateController::class, 'activate'])->name('activate');

        Route::delete('/delete', [PageUpdateController::class, 'delete'])->name('delete');
        
    });

    # Заказ #

    Route::group(['prefix' => 'order', 'as' => 'order.'], function() {
        Route::get('/', [OrderSelectController::class, 'index'])->name('select');
        
        Route::get('/{id}', [OrderUpdateController::class, 'index'])->name('update');
        Route::post('/{id}', [OrderUpdateController::class, 'update']);
        Route::delete('/{id}', [OrderUpdateController::class, 'delete']);

        Route::post('/cancel', [OrderUpdateController::class, 'cancel'])->name('cancel');

    });

    # Пользователь #

    Route::group(['prefix' => 'user', 'as' => 'user.'], function() {

        Route::get('/', [UserSelectController::class, 'index'])->name('select');
        
        Route::get('/{id}', [UserUpdateController::class, 'index'])->name('update');
        Route::post('/{id}', [UserUpdateController::class, 'update']);
        Route::delete('/{id}', [UserUpdateController::class, 'delete']);

        Route::get('/create', [UserCreateController::class, 'index'])->name('create');
        Route::post('/create', [UserCreateController::class, 'create']);

        Route::post('/login', [UserUpdateController::class, 'login'])->name('login');


    });

    # Группы пользователей #

    Route::group(['prefix' => 'role', 'as' => 'role.'], function() {

        Route::get('/', [RoleSelectController::class, 'index'])->name('select');
        
        Route::get('/{id}', [RoleUpdateController::class, 'index'])->name('update');
        Route::post('/{id}', [RoleUpdateController::class, 'update']);
        Route::delete('/{id}', [RoleUpdateController::class, 'delete']);

        Route::get('/create', [RoleCreateController::class, 'index'])->name('create');
        Route::post('/create', [RoleCreateController::class, 'create']);
    });

    # Меню #

    Route::group(['prefix' => 'menu', 'as' => 'menu.'], function() {

        Route::get('/', [MenuSelectController::class, 'index'])->name('select');
        
        Route::get('/{id}', [MenuUpdateController::class, 'index'])->name('update');
        Route::post('/{id}', [MenuUpdateController::class, 'update']);
        Route::delete('/{id}', [MenuUpdateController::class, 'delete'])->name('delete');

        Route::post('/delete_item',[MenuUpdateController::class, 'deleteItem'])->name('delete_item');
        Route::post('/update_items',[MenuUpdateController::class, 'updateItems'])->name('update_items');
        Route::post('/add_items', [MenuUpdateController::class, 'addItems'])->name('add_items');

        Route::get('/create', [MenuCreateController::class, 'index'])->name('create');
        Route::post('/create', [MenuCreateController::class, 'create']);
    });


    Route::group(['prefix' => 'store', 'as' => 'store.'], function() {

        Route::get('/create', [StoreCreateController::class, 'index'])->name('create');
        Route::post('/create', [StoreCreateController::class, 'create']);


        Route::get('/', [StoreSelectController::class, 'index'])->name('select');


        Route::get('/{id}', [StoreUpdateController::class, 'index'])->name('update');
        Route::post('/{id}', [StoreUpdateController::class, 'update']);

        Route::post('/deactivate', [StoreUpdateController::class, 'deactivate'])->name('deactivate');
        Route::post('/activate', [StoreUpdateController::class, 'activate'])->name('activate');

        Route::delete('/delete', [StoreUpdateController::class, 'delete'])->name('delete');

    });


});


# Static pages #

 foreach(app(PageService::class)->getRoutes() as $code) {
       Route::get($code, [PageController::class, 'index']);
 }

