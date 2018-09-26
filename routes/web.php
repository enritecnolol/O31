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
/*=================================\Pagina inicio/======================================================*/
Route::get('/', 'IndexController@index'); //pagina donde se vende



/*=================================\- API- /======================================================*/
Route::get('/facturacion', 'IndexController@store');// api para mandar datos de factura
Route::get('actualizar/producto', 'ApisController@actualizarp'); // api para actualizar los productos
Route::get('/cierrecaja', 'CajasController@cerrarcaja');// api para cerrar la caja en BD
Route::get('/historico/venta', 'ApisController@historico');// api para cerrar la caja en BD
Route::get('/caja/cuadrarcaja', 'CajasController@cuadrarcj');//api para guardar el cuadre de la casa
Route::get('/buscar/producto', 'ApisController@buscarproducto'); // api para buscar producto
Route::get('/buscar', 'ApisController@buscarp'); // api para buscar producto



/*=================================\Productos/======================================================*/
Route::resource('/productos', 'ProductsController'); // controller de manejo de los productos

/*=================================\CAJA/======================================================*/
Route::get('/caja', 'CajasController@index'); // controller para la caja
Route::get('/caja/apertura', 'CajasController@store');// api para mandar datos de factura
Route::get('/cierre/caja', 'CajasController@cierrecaja');//cierre de caja
Route::get('/caja/historico/ventas', 'CajasController@historico'); //  se usa?
Route::get('/caja/cuadre', 'CajasController@cuadrecaja'); // vista de el cuadre de caja





