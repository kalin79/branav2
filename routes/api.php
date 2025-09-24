<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\ParticipanteController;

use App\Http\Controllers\Api\V1\VideoController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\SeccionCorporativaController;
use App\Http\Controllers\Api\V1\UbigeoController;
use App\Http\Controllers\Api\V1\OrderController;
/*Route::group(['middleware' => ['guest']], function(){

    Route::get('home', [HomeController::class, 'home'])->name('api.home');

});*/

Route::middleware(['auth.secret'])->group(function () {

    Route::get('home', [HomeController::class, 'index'])->name('api.home');
    Route::get('productos', [HomeController::class, 'getProductos'])->name('api.productos');
    Route::get('video/{slug}', [VideoController::class, 'index'])->name('api.video-detalle');
    Route::get('producto/{slug}', [ProductController::class, 'index'])->name('api.producto-detalle');
    Route::get('seccion-corporativa/{slug_seccion}', [SeccionCorporativaController::class, 'getDataSection'])->name('api.terminos-y-condiciones');
    Route::get('/departments', [UbigeoController::class, 'getDepartments']);
    Route::get('/provinces/{department_id}', [UbigeoController::class, 'getProvinces']);
    Route::get('/districts/{department_id}/{province_id}', [UbigeoController::class, 'getDistricts']);
    Route::post('subscription', [HomeController::class, 'subscriptionStore'])->name('api.subscription');
    Route::post('contactanos/store', [HomeController::class, 'contactanos'])->name('api.contactanos');

    Route::post('/order/store', [OrderController::class, 'storeDatosCliente'])->name('api.order.store');
    Route::post('/order/checkout/{sale}', [OrderController::class, 'checkout'])->name('api.order.checkout');
    Route::post('/cliente/store', [ParticipanteController::class, 'store'])->name('api.participante.store');
    //Route::get('sorteo/{slug}', [ProductController::class, 'index'])->name('api.product');
    Route::post('/cliente/authenticate', [ParticipanteController::class, 'authenticate'])->name('api.participante.authenticate');
    Route::post('/cliente/refresh', [ParticipanteController::class, 'refresh']);


    //Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
    //Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
    // Rutas protegidas
    Route::middleware(['jwt.auth.cliente'])->group(function () {
        Route::post('/cliente/logout', [ParticipanteController::class, 'logout']);
        Route::get('/cliente/get-data', [ParticipanteController::class, 'me']);
        //Route::post('/participante/order', [OrderController::class, 'store'])->name('order.store');
        Route::post('/cliente/update', [ParticipanteController::class, 'update']);
        Route::get('/cliente/{participante}/get-order', [ParticipanteController::class, 'getOrder']);
        Route::post('/cliente/{id}/password', [ParticipanteController::class, 'updatePassword']);

    });


});

