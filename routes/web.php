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


Route::group(['middleware' => 'auth'], function () {

    /*=================================\Pagina inicio/======================================================*/
    Route::get('/', 'IndexController@index'); //pagina donde se vende

    /*=================================\- API- /======================================================*/
    Route::get('/facturacion', 'IndexController@store');// api para mandar datos de factura
//    Route::post('actualizar/producto', 'ApisController@actualizarp'); // api para actualizar los productos
    Route::get('/cierrecaja', 'CajasController@cerrarcaja');// api para cerrar la caja en BD
    Route::post('/historico/venta', 'ApisController@historico');// api para cerrar la caja en BD
    Route::post('/historico/venta/busqueda', 'ApisController@ventasbusqueda');// api para cerrar la caja en BD
    Route::get('/caja/cuadrarcaja', 'CajasController@cuadrarcj');//api para guardar el cuadre de la casa
    Route::get('/buscar/producto', 'ApisController@buscarproducto'); // api para buscar producto
    Route::get('/buscar', 'ApisController@buscarp'); // api para buscar producto
    Route::get('/buscar/producto/referencia', 'ApisController@buscarproductoreferencia'); // api para buscar producto
    Route::post('anja/{id}', 'ApisController@update' );// api para actualizar los productos

    ///////////////////////////////////////-Cuadre-/////////////////////////////////////////////////////////
    Route::post('/caja/cuadres/ver', 'ApisController@buscarcuadre'); // Ver Cuadre vista
    Route::post('/caja/cuadres', 'ApisController@cuadres'); // Ver Cuadre vista



    /*=================================\Productos/======================================================*/
    Route::resource('/productos', 'ProductsController'); // controller de manejo de los productos

    /*=================================\CAJA/======================================================*/
    Route::get('/caja', 'CajasController@index'); // controller para la caja
    Route::get('/caja/apertura', 'CajasController@store');// api para mandar datos de factura
    Route::get('/cierre/caja', 'CajasController@cierrecaja');//cierre de caja
    Route::get('/caja/historico/ventas', 'CajasController@historico'); //  se usa?
    Route::get('/caja/cuadre', 'CajasController@cuadrecaja'); // vista de el cuadre de caja
    Route::get('/caja/ver/cuadre', 'CajasController@vercuadre'); // Ver Cuadre vista

});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
