<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoRelacionadoController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CuidadoPersonalController;
use App\Http\Controllers\TiendaController;
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

Route::get('/', function(){
    return redirect('/admin/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function(){
        return redirect('/admin/home');
    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => ['guest']], function () {
        //Route::get('/', 'Auth\LoginController@showLoginForm');
        Route::get('/', [LoginController::class, 'showLoginForm']);
        Route::get('/login', [LoginController::class, 'showLoginForm']);
       // Route::get('/login', 'Auth\LoginController@showLoginForm');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
       // Route::post('/login', 'Auth\LoginController@login')->name('login');
    });

    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/home', [HomeController::class, 'index'])->name('home.index');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::get('usuarios', [UserController::class, 'index'])->name('administrator.index');
        Route::get('/usuarios/load', [UserController::class, 'load'])->name('administrator.load');
        Route::post('usuarios/register', [UserController::class, 'store'])->name('administrator.register');
        Route::get('usuarios/create', [UserController::class, 'create'])->name('administrator.create');
        Route::get('usuarios/edit/{user}', [UserController::class, 'edit'])->name('administrator.edit');
        Route::post('usuarios/update/{user}', [UserController::class, 'update'])->name('administrator.update');
        Route::post('usuarios/delete', [UserController::class, 'delete'])->name('administrator.delete');
        Route::post('usuarios/desactive', [UserController::class, 'desactive'])->name('administrator.desactive');
        Route::post('usuarios/active', [UserController::class, 'active'])->name('administrator.active');


        Route::get('/productos', [ProductoController::class, 'index'])->name('products.index');
        Route::get('/productos/load', [ProductoController::class, 'load'])->name('products.load');
        Route::get('producto/create', [ProductoController::class, 'create'])->name('products.create');
        Route::post('producto/store', [ProductoController::class, 'store'])->name('products.store');
        Route::get('producto/show/{product}', [ProductoController::class, 'show'])->name('products.show');
        Route::get('producto/edit/{product}', [ProductoController::class, 'edit'])->name('products.edit');
        Route::post('producto/update/{product}', [ProductoController::class, 'update'])->name('products.update');
        Route::post('producto/destroy/{product}', [ProductoController::class, 'destroy'])->name('products.destroy');
        Route::post('producto/desactive', [ProductoController::class, 'desactive'])->name('products.desactive');
        Route::post('producto/active', [ProductoController::class, 'active'])->name('products.active');
        Route::post('producto/update-order', [ProductoController::class, 'updateOrder'])->name('products.update-order');
        Route::get('producto/gallery/load/{product}', [ProductoController::class, 'loadGallery'])->name('products.gallery.load');
        Route::post('producto/gallery/update-order', [ProductoController::class, 'updateOrderImageGallery'])->name('products.gallery.update-order');
        Route::post('producto/gallery/destroy/{product}/{product_image}', [ProductoController::class, 'destroyImageGallery'])->name('products.gallery.destroy');

        Route::get('producto/{product}/relacionada', [ProductoRelacionadoController::class, 'index'])->name('products.relacionada.index');
        Route::get('producto/{product}/relacionada/load', [ProductoRelacionadoController::class, 'load'])->name('products.relacionada.load');
        Route::get('producto/{product}/relacionada/create', [ProductoRelacionadoController::class, 'create'])->name('products.relacionada.create');
        Route::get('producto/{product}/relacionada/list-load', [ProductoRelacionadoController::class, 'listProductLoad'])->name('products.relacionada.list-load');
        Route::post('producto/relacionada/store', [ProductoRelacionadoController::class, 'store'])->name('products.relacionada.store');
        Route::post('producto/relacionada/active', [ProductoRelacionadoController::class, 'active'])->name('products.relacionada.active');
        Route::post('producto/relacionada/desactive', [ProductoRelacionadoController::class, 'desactive'])->name('products.relacionada.desactive');
        Route::delete('producto/relacionada/destroy/{producto_relacionada}', [ProductoRelacionadoController::class, 'destroy'])->name('products.relacionada.destroy');

        Route::get('/banners', [BannersController::class, 'index'])->name('banner.index');
        Route::get('/banners/load', [BannersController::class, 'load'])->name('banner.load');
        Route::get('banners/create', [BannersController::class, 'create'])->name('banner.create');
        Route::post('banners/store', [BannersController::class, 'store'])->name('banner.store');
        Route::get('banners/show/{banner}', [BannersController::class, 'show'])->name('banner.show');
        Route::get('banners/edit/{banner}', [BannersController::class, 'edit'])->name('banner.edit');
        Route::post('banners/update/{banner}', [BannersController::class, 'update'])->name('banner.update');
        Route::post('banners/destroy/{banner}', [BannersController::class, 'destroy'])->name('banner.destroy');
        Route::post('banners/desactive', [BannersController::class, 'desactive'])->name('banner.desactive');
        Route::post('banners/active', [BannersController::class, 'active'])->name('banner.active');
        Route::post('banners/update-order', [BannersController::class, 'updateOrder'])->name('banner.update-order');
        Route::get('/banners/list-videos-campana', [BannersController::class, 'getListCatalogo'])->name('banner.list-videos-campana');

        Route::get('/categorias', [CategoriaController::class, 'index'])->name('categories.index');
        Route::get('/categorias/load/{parent_id?}', [CategoriaController::class, 'load'])->name('categories.load');
        Route::get('categorias/create/{parent_id?}', [CategoriaController::class, 'create'])->name('categories.create');
        Route::post('categorias/store', [CategoriaController::class, 'store'])->name('categories.store');
        Route::get('categorias/show/{categoria}', [CategoriaController::class, 'show'])->name('categories.show');
        Route::get('categorias/edit/{categoria}', [CategoriaController::class, 'edit'])->name('categories.edit');
        Route::post('categorias/update/{categoria}', [CategoriaController::class, 'update'])->name('categories.update');
        Route::post('categorias/destroy/{categoria}', [CategoriaController::class, 'destroy'])->name('categories.destroy');
        Route::post('categorias/desactive', [CategoriaController::class, 'desactive'])->name('categories.desactive');
        Route::post('categorias/active', [CategoriaController::class, 'active'])->name('categories.active');
        Route::post('categorias/update-order', [CategoriaController::class, 'updateOrder'])->name('categories.update-order');
        Route::get('/categorias/{categoria}', [CategoriaController::class, 'index'])->name('subcategories.index');
        Route::get('/sub-categorias/list', [CategoriaController::class, 'getListSubCategorias'])->name('subcategories.list');
        Route::get('/categorias-list', [CategoriaController::class, 'getListCategory'])->name('categories.list-category');

        Route::get('/cuidado-personal', [CuidadoPersonalController::class, 'index'])->name('cuidado-personal.index');
        Route::get('/cuidado-personal/load', [CuidadoPersonalController::class, 'load'])->name('cuidado-personal.load');
        Route::get('cuidado-personal/create', [CuidadoPersonalController::class, 'create'])->name('cuidado-personal.create');
        Route::post('cuidado-personal/store', [CuidadoPersonalController::class, 'store'])->name('cuidado-personal.store');
        Route::get('cuidado-personal/show/{cuidado_personal}', [CuidadoPersonalController::class, 'show'])->name('cuidado-personal.show');
        Route::get('cuidado-personal/edit/{cuidado_personal}', [CuidadoPersonalController::class, 'edit'])->name('cuidado-personal.edit');
        Route::post('cuidado-personal/update/{cuidado_personal}', [CuidadoPersonalController::class, 'update'])->name('cuidado-personal.update');
        Route::post('cuidado-personal/destroy/{cuidado_personal}', [CuidadoPersonalController::class, 'destroy'])->name('cuidado-personal.destroy');
        Route::post('cuidado-personal/desactive', [CuidadoPersonalController::class, 'desactive'])->name('cuidado-personal.desactive');
        Route::post('cuidado-personal/active', [CuidadoPersonalController::class, 'active'])->name('cuidado-personal.active');
        Route::post('cuidado-personal/update-order', [CuidadoPersonalController::class, 'updateOrder'])->name('cuidado-personal.update-order');

        Route::get('/tiendas', [TiendaController::class, 'index'])->name('tienda.index');
        Route::get('/tienda/load', [TiendaController::class, 'load'])->name('tienda.load');
        Route::get('tienda/create', [TiendaController::class, 'create'])->name('tienda.create');
        Route::post('tienda/store', [TiendaController::class, 'store'])->name('tienda.store');
        Route::get('tienda/show/{tienda}', [TiendaController::class, 'show'])->name('tienda.show');
        Route::get('tienda/edit/{tienda}', [TiendaController::class, 'edit'])->name('tienda.edit');
        Route::post('tienda/update/{tienda}', [TiendaController::class, 'update'])->name('tienda.update');
        Route::post('tienda/destroy/{tienda}', [TiendaController::class, 'destroy'])->name('tienda.destroy');
        Route::post('tienda/desactive', [TiendaController::class, 'desactive'])->name('tienda.desactive');
        Route::post('tienda/active', [TiendaController::class, 'active'])->name('tienda.active');
        Route::post('tienda/update-order', [TiendaController::class, 'updateOrder'])->name('tienda.update-order');
    });
});



Route::get('/clear-cache', function () {
    echo Artisan::call('config:clear');
    echo Artisan::call('config:cache');
    echo Artisan::call('cache:clear');
    echo Artisan::call('route:clear');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/{any}', function () {
    return view('frontend.app'); // el blade con #app
})->where('any', '.*');
