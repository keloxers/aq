<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function() {
    Route::auth();
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index');


    Route::post('/articulos/finder', [ 'as' => 'articulos.finder', 'uses' => 'ArticulosController@finder']);
    Route::get( '/articulos/search', array('as' => 'articulos.search', 'uses' => 'ArticulosController@search'));
    Route::resource('articulos', 'ArticulosController');

    Route::get( '/articulosmovimientos', array('as' => 'articulos.articulosmovimientos', 'uses' => 'ArticulosController@articulosmovimientos'));
    Route::post( '/articulos/articulosmovimientosstore', array('as' => 'articulos.articulosmovimientosstore', 'uses' => 'ArticulosController@articulosmovimientosstore'));

    Route::post('/barrios/finder', [ 'as' => 'barrios.finder', 'uses' => 'BarriosController@finder']);
    Route::get( '/barrios/search', array('as' => 'barrios.search', 'uses' => 'BarriosController@search'));
    Route::resource('barrios', 'BarriosController');

    Route::post('/agentes/finder', [ 'as' => 'agentes.finder', 'uses' => 'AgentesController@finder']);
    Route::get( '/agentes/search', array('as' => 'agentes.search', 'uses' => 'AgentesController@search'));
    Route::get( '/agentes/{id}/juegos', array('as' => 'agentes.juegos', 'uses' => 'AgentesController@juegos'));
    Route::get( '/agentes/{id}/createjuegos', array('as' => 'agentes.createjuegos', 'uses' => 'AgentesController@createjuegos'));
    Route::post( '/agentes/storeagentesjuegos', array('as' => 'agentes.storeagentesjuegos', 'uses' => 'AgentesController@storeagentesjuegos'));
    Route::get( '/agentes/agentesjuegos/delete/{id}', array('as' => 'agentes.createjuegosdestroy', 'uses' => 'AgentesController@createjuegosdestroy'));

    Route::get( '/agentes/agentesjuegos/changestatus/{id}', array('as' => 'agentes.changestatus', 'uses' => 'AgentesController@changestatus'));
    
    Route::resource('agentes', 'AgentesController');

    Route::post('/juegos/finder', [ 'as' => 'juegos.finder', 'uses' => 'JuegosController@finder']);
    Route::get( '/juegos/search', array('as' => 'juegos.search', 'uses' => 'JuegosController@search'));
    Route::get( '/juegos/searchcartones', array('as' => 'juegos.searchcartones', 'uses' => 'JuegosController@searchcartones'));
    
    Route::resource('juegos', 'JuegosController');

    Route::post('/cartonsagentes/finder', [ 'as' => 'cartonsagentes.finder', 'uses' => 'CartonsagenteController@finder']);
    Route::get( '/cartonsagentes/search', array('as' => 'cartonsagentes.search', 'uses' => 'CartonsagenteController@search'));
    Route::get( '/cartonsagentes/{id}/pago', array('as' => 'cartonsagentes.pago', 'uses' => 'CartonsagenteController@pago'));
    
    Route::resource('cartonsagentes', 'CartonsagenteController');    
    

    Route::post('/rendicions/finder', [ 'as' => 'rendicions.finder', 'uses' => 'RendicionsController@finder']);
    Route::get( '/rendicions/search', array('as' => 'rendicions.search', 'uses' => 'RendicionsController@search'));
    Route::post( '/rendicions/storepagos', array('as' => 'rendicions.storepagos', 'uses' => 'RendicionsController@storepagos'));
    Route::get( '/rendicions/{id}/cerrar', array('as' => 'rendicions.cerrar', 'uses' => 'RendicionsController@cerrar'));
    Route::get( '/rendicions/{id}/cerrada', array('as' => 'rendicions.cerrada', 'uses' => 'RendicionsController@cerrada'));
    Route::get( '/rendicions/{id}/controlada', array('as' => 'rendicions.controlada', 'uses' => 'RendicionsController@controlada'));
    Route::get( '/rendicions/{id}/saldoaefectivo', array('as' => 'rendicions.saldoaefectivo', 'uses' => 'RendicionsController@saldoaefectivo'));
    Route::post('/rendicions/filtrar', [ 'as' => 'rendicions.filtrar', 'uses' => 'RendicionsController@filtrar']);
    
    Route::resource('rendicions', 'RendicionsController');

    Route::get( '/detalles/{id}/detalles', array('as' => 'detalles.detalles', 'uses' => 'DetallesController@detalles'));
    Route::get( '/detalles/{id}/create', array('as' => 'detalles.create', 'uses' => 'DetallesController@create'));
    Route::post('/detalles/finder', [ 'as' => 'detalles.finder', 'uses' => 'DetallesController@finder']);
    Route::get( '/detalles/search', array('as' => 'detalles.search', 'uses' => 'DetallesController@search'));

    Route::resource('detalles', 'DetallesController');

    Route::post('/cuentas/finder', [ 'as' => 'cuentas.finder', 'uses' => 'CuentasController@finder']);
    Route::get( '/cuentas/search', array('as' => 'cuentas.search', 'uses' => 'CuentasController@search'));
    Route::resource('cuentas', 'CuentasController');

    Route::post('/planillas/finder', [ 'as' => 'planillas.finder', 'uses' => 'PlanillasController@finder']);
    Route::get( '/planillas/{id}/cerrar', array('as' => 'planillas.cerrar', 'uses' => 'PlanillasController@cerrar'));
    Route::get( '/planillas', array('as' => 'planillas.indexshow', 'uses' => 'PlanillasController@indexshow'));
    Route::post('/planillas/view', [ 'as' => 'planillas.view', 'uses' => 'PlanillasController@view']);

    Route::get( '/estadoscuenta', array('as' => 'planillas.estadoscuenta', 'uses' => 'PlanillasController@estadoscuenta'));
    Route::post( '/estadoscuenta', array('as' => 'planillas.estadoscuentashow', 'uses' => 'PlanillasController@estadoscuentashow'));

    Route::get( '/estadoscuenta/todasdeudas', array('as' => 'planillas.todasdeudas', 'uses' => 'PlanillasController@todasdeudas'));

    Route::post('/movimientos/finder', [ 'as' => 'movimientos.finder', 'uses' => 'MovimientosController@finder']);


    Route::resource('movimientos', 'MovimientosController');



});
