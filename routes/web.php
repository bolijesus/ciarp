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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//TODOS LOS MENUS
//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('usuarios', 'MenuController@usuarios')->name('admin.usuarios');
    Route::get('solicitud', 'MenuController@solicitud')->name('admin.solicitud');
    Route::get('pqr', 'PqrController@index')->name('admin.pqr');
    Route::get('reporte', 'MenuController@reporte')->name('admin.reporte');
    Route::post('acceso', 'HomeController@confirmaRol')->name('rol');
    Route::get('inicio', 'HomeController@inicio')->name('inicio');
});

//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN DE USUARIOS
Route::group(['middleware' => 'auth', 'prefix' => 'usuarios'], function() {
    //MODULOS
    Route::resource('modulo', 'ModuloController');
    //PAGINAS O ITEMS DE LOS MODULOS
    Route::resource('pagina', 'PaginaController');
    //GRUPOS DE USUARIOS
    Route::resource('grupousuario', 'GrupousuarioController');
    Route::get('grupousuario/{id}/delete', 'GrupousuarioController@destroy')->name('grupousuario.delete');
    Route::get('privilegios', 'GrupousuarioController@privilegios')->name('grupousuario.privilegios');
    Route::get('grupousuario/{id}/privilegios', 'GrupousuarioController@getPrivilegios');
    Route::post('grupousuario/privilegios', 'GrupousuarioController@setPrivilegios')->name('grupousuario.guardar');
    //USUARIOS
    Route::resource('usuario', 'UsuarioController');
    Route::get('usuario/{id}/delete', 'UsuarioController@destroy')->name('usuario.delete');
    Route::post('operaciones', 'UsuarioController@operaciones')->name('usuario.operaciones');
    Route::post('usuario/contrasenia/cambiar/admin/finalizar', 'UsuarioController@cambiarPass')->name('usuario.cambiarPass');
});

//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN DEL MÓDULO DE SOLICITUD
Route::group(['middleware' => 'auth', 'prefix' => 'solicitud'], function() {
    //DOCENTE
    Route::resource('docente', 'DocenteController');
    Route::get('docente/{id}/delete', 'DocenteController@destroy')->name('docente.delete');
    //FECHAS DE CIERRE
    Route::resource('fecha', 'FechacierreController');
    Route::get('fecha/{id}/delete', 'FechacierreController@destroy')->name('fecha.delete');
    //FECHAS DE PQR
    Route::resource('fechapqr', 'FechapqrController');
    Route::get('fechapqr/{id}/delete', 'FechapqrController@destroy')->name('fechapqr.delete');
    //ARTICULOS
    Route::resource('articulo', 'ArticuloController');
    Route::get('articulo/index/administrador', 'ArticuloController@indexadmin')->name('articulo.indexadmin');
    Route::get('articulo/{articulo}/evaluar/solicitud', 'ArticuloController@evaluar')->name('articulo.evaluar');
    Route::post('articulo/evaluar/calificar/solicitud', 'ArticuloController@calificar')->name('articulo.calificar');
    Route::get('articulo/{id}/delete', 'ArticuloController@destroy')->name('articulo.delete');
    //LIBROS
    Route::resource('libro', 'LibroController');
    Route::get('libro/index/administrador', 'LibroController@indexadmin')->name('libro.indexadmin');
    Route::get('libro/{libro}/evaluar/solicitud', 'LibroController@evaluar')->name('libro.evaluar');
    Route::post('libro/evaluar/calificar/solicitud', 'LibroController@calificar')->name('libro.calificar');
    Route::get('libro/{id}/delete', 'LibroController@destroy')->name('libro.delete');
    //SOFTWARE
    Route::resource('software', 'SoftwareController');
    Route::get('software/index/administrador', 'SoftwareController@indexadmin')->name('software.indexadmin');
    Route::get('software/{software}/evaluar/solicitud', 'SoftwareController@evaluar')->name('software.evaluar');
    Route::post('software/evaluar/calificar/solicitud', 'SoftwareController@calificar')->name('software.calificar');
    Route::get('software/{id}/delete', 'SoftwareController@destroy')->name('software.delete');
    //PONENCIA
    Route::resource('ponencia', 'PonenciaController');
    Route::get('ponencia/index/administrador', 'PonenciaController@indexadmin')->name('ponencia.indexadmin');
    Route::get('ponencia/{ponencia}/evaluar/solicitud', 'PonenciaController@evaluar')->name('ponencia.evaluar');
    Route::post('ponencia/evaluar/calificar/solicitud', 'PonenciaController@calificar')->name('ponencia.calificar');
    Route::get('ponencia/{id}/delete', 'PonenciaController@destroy')->name('ponencia.delete');
    //PQR
    Route::resource('pqr', 'PqrController');
    Route::post('pqr/create/post', 'PqrController@store2')->name('pqr.store2');
    Route::get('pqr/{id}/delete', 'PqrController@destroy')->name('pqr.delete');
});

//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN DEL MÓDULO DE REPORTES
Route::group(['middleware' => 'auth', 'prefix' => 'reportes'], function() {
    //SOLICITUDES
    Route::resource('reporte', 'ReporteController');
    Route::get('reporte/menu/acta', 'ReporteController@acta')->name('reportes.acta');
    Route::get('reporte/acta/{anio}/{periodo}/pdf', 'ReporteController@acta_pdf')->name('reportes.acta_pdf');
    Route::get('reporte/menu/productividad', 'ReporteController@productividad')->name('reportes.productividad');
    Route::get('reporte/menu/{estado}/{fechai}/{fechaf}/{tipo}/{documento}/productividad', 'ReporteController@getSolicitudes')->name('reportes.getProductividad');
    Route::get('reporte/menu/por/conductor', 'ReporteController@porconductor')->name('reportes.porconductor');
    Route::get('reporte/{identificacion}/porconductor', 'ReporteController@traer')->name('reportes.traer');
});
