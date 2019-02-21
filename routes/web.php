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


//Route::get('/login', 'Auth\Authcontroller@loginview');
//Route::post('/login', 'Auth\Authcontroller@login');

/*=================================\- Admin -/======================================================*/
Route::group(['middleware'=>'basicAuth'],function () {

    Route::get('/admin', 'AdminController@index');
    Route::post('/user/list', 'AdminController@userlist');
    Route::post('/user/connection/store', 'AdminController@store');
    Route::post('/user/connection/edit', 'AdminController@edit');

});
/*=================================\- Admin -/======================================================*/
Route::group(['middleware' => 'auth'], function () {

    /*=================================\Pagina inicio/======================================================*/
    Route::get('/', 'IndexController@index'); //pagina donde se vende
    Route::post('/productos/index', 'IndexController@productos'); //productos index
    Route::group(['domain' => '{subdomain}.'.config('app.domain')], function () {});

    /*=================================\- API- /======================================================*/
    Route::get('/facturacioncar', 'IndexController@store'); // api para mandar datos de factura
//    Route::post('actualizar/producto', 'ApisController@actualizarp'); // api para actualizar los productos
    Route::get('/cierrecaja', 'CajasController@cerrarcaja');// api para cerrar la caja en BD
    Route::get('/historico/venta', 'ApisController@historico');// api para cerrar la caja en BD
    Route::get('/lista/productos', 'ApisController@productos');// api para cerrar la caja en BD
    Route::post('/historico/venta/busqueda', 'ApisController@ventasbusqueda');// api para cerrar la caja en BD
    Route::get('/caja/cuadrarcaja', 'CajasController@cuadrarcj');//api para guardar el cuadre de la casa
    Route::get('/buscar/producto', 'ApisController@buscarproducto'); // api para buscar producto
    Route::post('/buscar/producto/ordenes', 'ApisController@buscarproductoordenes'); // api para buscar producto
    Route::get('/buscar', 'ApisController@buscarp'); // api para buscar producto
    Route::get('/buscar/producto/referencia', 'ApisController@buscarproductoreferencia'); // api para buscar producto
    Route::post('anja/{id}', 'ApisController@update' );// api para actualizar los productos
    Route::post('eliminar/producto', 'ApisController@eliminarproducto' );// Eliminar productos
    Route::post('/itbis/producto', 'ApisController@itbisporproducto' );// Eliminar productos
    Route::post('/reportes/resultado', 'ApisController@ultimoid' );//
    Route::post('/productos/paginate', 'ApisController@productospaginado' );//
    Route::get('ver/categoria/get', 'ApisController@cargarcategoria' );// api para actualizar los productos

    ///////////////////////////////////////-Categoria-////////////////////////////////////////////////////
    Route::post('/crear/categoria', 'ApisController@crearcategoriarapida');// api para agregar categoria rapido en productos
    Route::post('/ver/categoria', 'ApisController@cargarcategoria');// api ver categoria
    Route::post('vender/productos/categoria', 'ApisController@productoscategoria' );// api para sacar las categoria en la pantalla de vender
    Route::get('productos/categoria', 'ApisController@productosporcategoria' );//productos por categoria
    Route::post('/productos/categoria/ordenes', 'ApisController@productosporcategoriaordenes' );//productos por categoria

    ///////////////////////////////////////-Cuadre-/////////////////////////////////////////////////////////
    Route::post('/caja/cuadres/ver', 'ApisController@buscarcuadre'); // Ver Cuadre vista buscador
    Route::post('/caja/cuadres', 'ApisController@cuadres'); // Ver Cuadre vista
    Route::get('/formato/cuadre/{id}', 'CajasController@idcuadre'); //desglose un el id del cuadre
    Route::post('/cuadre/infocaja', 'CajasController@infocaja'); //buscar informacion de la caja para hacer el cuadre

    /*=================================\Productos/======================================================*/
    Route::resource('/productos', 'ProductsController'); // controller de manejo de los productos
    Route::post('/all/productos', 'ApisController@allproduct'); // controller de manejo de los productos

    /*=================================\Categorias/======================================================*/
    Route::get('categorias', 'CategoriasController@index'); // controller de manejo de los productos
    Route::post('categorias/nueva', 'CategoriasController@nuevacategoria'); // controller de manejo de los productos
    Route::post('categorias/edit', 'CategoriasController@editarcategoria'); // controller de manejo de los productos
    Route::get('categoria/editar/{id}', 'CategoriasController@buscarcategoria'); // controller de manejo de los productos
    Route::post('/all/categories', 'CategoriasController@allcategories'); // controller de manejo de los productos

    /*=================================\Sub -- Categorias/======================================================*/
    Route::post('nueva/subcategoria', 'SubcategoriasController@crearsubcategoria'); //Controller para ingresar nueva subtarea
    Route::post('/mostrar/subcategorias', 'SubcategoriasController@mostrarsubcategorias'); //buscar todas las subcategorias de una categoria
    Route::post('edit/subcategoria/{id}', 'SubcategoriasController@subcategoriaeditar'); //buscar todas las subcategorias de una categoria
    Route::post('datos/subcategoria', 'SubcategoriasController@editarsubcategoria'); //datos de subcategoria para editar
    Route::post('subcategoria/producto', 'SubcategoriasController@productosubcategoria'); // Buscar las subcategoria para asociar los con los productos
    Route::post('subcategoria/rapida', 'SubcategoriasController@nuevasubcategoria'); // inserta subcategoria rapido en pantalla de producto
    Route::post('subcategoria/vender', 'SubcategoriasController@subcategoriavender'); // inserta subcategoria rapido en pantalla de producto
    Route::post('subcategoria/productos', 'SubcategoriasController@subcategoriaproductos'); // buscar los productos que pertenezcan en esa subcategoria
    Route::post('/ver/subcategorias', 'SubcategoriasController@versubcategorias'); // mostrar las subacetgorias en la parte de editar productos
    Route::post('eliminar/dos', 'SubcategoriasController@eliminardos'); // Eliminar Categoria y subcategoria junta
    Route::post('eliminar/subcategoria', 'SubcategoriasController@eliminarsubcategoria'); // Eliminar subcategoria

    /*=================================\CAJA/======================================================*/
    Route::get('/caja', 'CajasController@index'); // controller para la caja
    Route::get('/caja/apertura', 'CajasController@store');// api para mandar datos de factura
    Route::get('/cierre/caja', 'CajasController@cierrecaja');//cierre de caja
    Route::get('/caja/historico/ventas', 'CajasController@historico'); //  se usa?
    Route::get('/caja/cuadre', 'CajasController@cuadrecaja'); // vista de el cuadre de caja
    Route::get('/caja/ver/cuadre', 'CajasController@vercuadre'); // Ver Cuadre vista
    /*=================================\- DashBoard- /======================================================*/
    Route::get('/dashboard', 'ApisController@dashboard'); // Dashboard index
    /*=================================\- Reportes- /======================================================*/
    Route::get('/reportes', 'ReportesController@index');// muesta las vista
    Route::get('/reportes/resultado', 'ReportesController@busqueda'); // busca las facturas por rango de fecha
    Route::get('/reportes/{start}/{end}', 'ReportesController@reporteporproductos'); //
    Route::get('/reportes/imprimir/{start}/{end}', 'ReportesController@imprimirventas'); //
    Route::get('/reportes/productos/{start}/{end}', 'ReportesController@reporteproducto'); //
    Route::get('/reportes/imprimir/productos/{start}/{end}', 'ReportesController@imprimirreporteproducto'); //
    Route::get('/reportes/inicio', 'ReportesController@inicio'); //
    Route::get('/reportes/imprimir', 'ReportesController@imprimir'); //
    /*=================================\- Configuracion - /======================================================*/
    Route::get('/configuracion','ConfiguracionesController@index');//muestra vista para configurar la compania
    Route::post('/configuracion/store','ConfiguracionesController@store'); // guardar configuracion
    Route::post('/configuracion/edit','ConfiguracionesController@update');// editar configuracion
    Route::get('/configuracion/cliente/preferencial','ConfiguracionesController@clientepreferencialindex');
    Route::post('/configuracion/existencia','ConfiguracionesController@existencia');
    Route::post('/configuracion/manejo/itbis','ConfiguracionesController@manejoitbis');
    Route::post('/configuracion/sale','ConfiguracionesController@setting');
    /*=================================\- itbis - /======================================================*/
    Route::get('/configuracion/itbis','ImpuestosController@itbis');
    Route::post('/nuevo/itbis','ImpuestosController@store');
    Route::post('/itbis/datos','ImpuestosController@datos');
    Route::post('/itbis/editar/buscar','ImpuestosController@editarbuscardatos');
    Route::post('/itbis/editar','ImpuestosController@editaritbis');
    /*=================================\- Impuesto ref- /======================================================*/
    Route::post('/impuestoref/nuevo','ImpuestosrefsController@store');
    Route::post('/impuestoref/datos','ImpuestosrefsController@datos');
    Route::post('/impuestoref/ingresar/rango','ImpuestosrefsController@ingresarrango');
    Route::post('/impuestoref/editar/rango','ImpuestosrefsController@editarrango');
    Route::post('/impuestoref/datos/producto','ImpuestosrefsController@datosimpuestorefproducto');
    /*=================================\- Clientes -/======================================================*/
    Route::get('/clientes','ClientesController@index');
    Route::post('/clientes/store','ClientesController@store');
    Route::post('/clientes/datos/tabla','ClientesController@datostabla');
    Route::post('/clientes/datos/tabla2','ClientesController@datostabla2');
    Route::post('/clientes/datos','ClientesController@clientepuntos');
    Route::post('/clientes/edit','ClientesController@edit');
    Route::post('/clientes/buscar/cliente','ClientesController@buscarcliente');
    Route::post('/clientes/cliente/tarjeta','ClientesController@clientetarjeta');
    Route::post('/cambio/puntos','ClientesController@cambiopuntos');
    Route::post('/cliente/buscar/nombre','ClientesController@nombrecliente');

    /*=================================\- Tickets -/======================================================*/
    Route::post('/ticket/busqueda','PuntosmovimientosController@buscadorticket');
    Route::post('/ticket/todos','PuntosmovimientosController@tickets');
    Route::post('/ticket/cliente/tickets','PuntosmovimientosController@movimientocliente');

    /*=================================\- Tipo de tarjeta -/======================================================*/
    Route::get('/tipo/tarjeta','TipostarjetasController@index');
    Route::post('/tipo/tarjeta/store','TipostarjetasController@store');
    Route::post('/tipo/tarjeta/datos/tabla','TipostarjetasController@datostabla');
    Route::post('/tipo/tarjeta/edit','TipostarjetasController@edit');

    /*=================================\- Config Tipo de tarjeta -/======================================================*/
    Route::post('/config/tipo/tarjeta/store','ConfigtjsController@store');
    Route::post('/config/tipo/tarjeta/buscar','ConfigtjsController@buscartj');
    Route::post('/config/tipo/tarjeta/edit','ConfigtjsController@edit');

    /*=================================\- Devolucion -/======================================================*/
    Route::get('/devolucion','DevolucionesController@index');
    Route::post('/devolucion/buscar/factura','DevolucionesController@buscarfactura');
    Route::post('/devolucion/buscando/producto','DevolucionesController@buscandoproductos');
    Route::post('/devolucion/store','DevolucionesController@store');

    /*=================================\- Provedores -/======================================================*/
    Route::get('/provedores', 'ProvedoresController@index');
    Route::post('/provedores/store', 'ProvedoresController@store');
    Route::post('/provedores/edit', 'ProvedoresController@edit');
    Route::post('/provedores/todos/datos', 'ProvedoresController@todosdatos');
    Route::post('/provedores/todos/provedores', 'ProvedoresController@todosprovedores');

    /*=================================\- Tipo Cuentas por pagar -/======================================================*/
    Route::post('/tcxp/store', 'TcxpsController@store');
    Route::post('/tcxp/datos/todos', 'TcxpsController@todosdatos');

    /*=================================\- Tipo comprobantes -/======================================================*/
    Route::post('/tipo/comprobante/store', 'TipocomprobantesController@store');
    Route::post('/tipo/comprobante/datos/tabla', 'TipocomprobantesController@datostabla');

    /*=================================\- Gastos -/======================================================*/
    Route::get('/entrada/comprobante', 'GastosController@index');
    Route::get('/pago/entrada/comprobante', 'GastosController@pagoindex');
    Route::post('/entrada/comprobante/store', 'EntradacomprobantesController@store');
    Route::post('/entrada/comprobante/provedor', 'EntradacomprobantesController@comprobanteporprovedor');
    Route::post('/entrada/comprobante/pago', 'EntradacomprobantesController@pago');
    Route::post("/entrada/comprobante/data/rnc", "EntradacomprobantesController@datarnc");

    /*=================================\- Tipo Factura -/======================================================*/
    Route::post('/tipo/factura/store', 'TipofacturasController@store');
    Route::post('/tipo/factura/datos', 'TipofacturasController@datos');

    /*=================================\- Pago de Comprobante -/======================================================*/
    Route::post('/pago/comprobante', 'PagocomprobantesController@store');

    /*=================================\- Control de Inventario -/======================================================*/
    Route::get('/control/inventario', 'ControlinventariosController@index');
    Route::post('/todos/productos', 'ControlinventariosController@todosproductos');
    Route::post('/store/compra', 'ControlinventariosController@storecompra');
//    Route::post('', '');
    /*=================================\- Facturacion -/======================================================*/
    Route::get('/facturacion', 'FacturacionesController@index');

    /*=================================\- Corotos -/======================================================*/
    Route::post('/salvar/coroto', 'CorotosController@store');
    Route::post('/edit/coroto', 'CorotosController@edit');
    Route::post('/delete/coroto', 'CorotosController@delete');
    Route::post('/corotos/all', 'CorotosController@allcorotos');
    Route::post('/save/edit/corotos', 'CorotosController@saveeditcorotos');
    Route::post('/change/name/coroto', 'CorotosController@changename');

    /*=================================\- Areas -/======================================================*/
    Route::post('/save/area', 'AreasController@store');
    Route::post('/all/area', 'AreasController@allareas');

    /*=================================\- Comanda -/======================================================*/
    Route::get('/comanda', 'OrdensController@Comanda');

    /*=================================\- Mesa -/======================================================*/
    Route::post('/mesa/temp/store', 'MesatempsController@store');
    Route::post('/mesa/temp/all', 'MesatempsController@all');
    Route::post('/buscar/orden/x/mesa', 'MesatempsController@ordenxmesa');
    Route::post('/producto/orden', 'MesatempsController@productoselect');


    /*=================================\- Ordenar Mesa -/======================================================*/
    Route::post('/ordenar/mesa/store', 'OrdensController@store');
    Route::post('/producto/orden/cambiar/cantidad', 'OrdensController@cambiarcantidad');
    Route::post('/producto/orden/eliminar', 'OrdensController@eliminarprod');
    Route::post('/orden/cancelar/orden', 'OrdensController@cancelarorden');
    Route::post('/orden/facturar', 'OrdensController@facturarorden');

    /*=================================\- Vistas de ordenes -/======================================================*/
    Route::get('/ordenes/preparar', 'OrdensController@viewprepararordenes');
    Route::post('/all/ordens/open', 'OrdensController@allordenesabiertas');
    Route::post('/all/ordens/details', 'OrdensController@allordenesdetalle');
    Route::post('/cambio/estado/item/orden', 'OrdensController@cambioestadoordenitem');

    /*=================================\- Camareros -/======================================================*/
    Route::get('/camareros', 'CamarerosController@index');
    Route::post('/camareros/store', 'CamarerosController@store');
    Route::post('/camareros/edit', 'CamarerosController@edit');
    Route::post('/camareros/delete', 'CamarerosController@delete');
    Route::post('/camareros/all', 'CamarerosController@allcamareros');
    Route::post('/camareros/all/pagination', 'CamarerosController@allcamarerospagination');
    /*=================================\- Comprobantes -/======================================================*/
    Route::get("/comprobantes", "ComprobantesController@index");
    Route::post("/comprobantes/store", "ComprobantesController@store");
    Route::post("/comprobantes/all/header", "ComprobantesController@allheader");
    Route::post("/comprobantes/find/header/details", "ComprobantesController@findheader");
    Route::post("/comprobantes/find/header/details", "ComprobantesController@findheader");
    Route::post("/comprobantes/edit/detail/sequence", "ComprobantesController@editdetail");
    Route::post("/data/rnc", "ComprobantesController@datarnc");
    /*=================================\- ReporteriaV2 -/======================================================*/
    Route::get('/reportv2', 'Reporteriav2Controller@index');
    Route::post('/reportv2/comprobantes/fiscales', 'Reporteriav2Controller@typenfcdata');
    Route::post('/reportv2/return/data', 'Reporteriav2Controller@returndata');

    /*=================================\- Password -/======================================================*/
    Route::post('/change/pass', 'ConfiguracionesController@changepass');
});

Auth::routes();
