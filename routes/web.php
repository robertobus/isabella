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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => ['auth', 'acl'], 'is' => 'administrador'], function(){
        /* Admin Users */
        Route::get('admin/usuario/listar', 'Admin\UsuarioController@listar');
        Route::get('admin/usuario/nuevo', 'Admin\UsuarioController@usuario');
        Route::get('admin/usuario/detalle/{id}', 'Admin\UsuarioController@usuario');
        Route::post('admin/usuario/guardar', 'Admin\UsuarioController@guardar');
        Route::post('admin/usuario/actualizar', 'Admin\UsuarioController@actualizar');
    });
    Route::get('/admin/usuario/permisos', 'Admin\UsuarioController@permisos');

    /* Admin Medico */
    Route::get('medico/listar', 'Admin\MedicoController@tolist');
    Route::get('medico/listardata', 'Admin\MedicoController@tolistData');
    Route::get('medico/nuevo', 'Admin\MedicoController@create');
    Route::post('medico/guardar', 'Admin\MedicoController@store');
    Route::get('medico/detalle/{id}', 'Admin\MedicoController@edit');
    Route::post('medico/actualizar/{id}', 'Admin\MedicoController@update');

    /* Admin Pacientes */
    Route::get('paciente/listar', 'Admin\PacienteController@tolist');
    Route::get('paciente/listardata', 'Admin\PacienteController@tolistData');
    Route::get('paciente/nuevo', 'Admin\PacienteController@create');
    Route::post('paciente/guardar', 'Admin\PacienteController@store');
    Route::get('paciente/detalle/{id}', 'Admin\PacienteController@edit');
    Route::post('paciente/actualizar/{id}', 'Admin\PacienteController@update');

    /* Practicas - Analisis */
    Route::get('analisis/busqueda', 'Practicas\AnalisisController@tolist');
    Route::get('analisis/nuevo', 'Practicas\AnalisisController@create');
    Route::post('analisis/guardar', 'Practicas\AnalisisController@store');
    Route::get('analisis/detalle/{id}', 'Practicas\AnalisisController@edit');
    Route::post('analisis/actualizar/{id}', 'Practicas\AnalisisController@update');

    Route::get('analisis/export/{id}', 'Practicas\AnalisisController@export');

    Route::get('seguridad/bloqueado', 'Admin\ErrorAccessController@index');

});
