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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );
Route::get('/perfil', 'UserController@perfil')->name('perfil' );
Route::get('/edit-password', 'UserController@editPassword')->name('edit.password' );
Route::put('/user-password-update', 'UserController@passwordUpdate')->name('user.password.update' );

Route::resource('user', 'UserController');
Route::resource('tipos-usuarios', 'TiposUsuariosController');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('centros-custos', 'CentrosCustosController');
    Route::resource('solicitantes', 'SolicitantesController');
    Route::resource('frotas', 'FrotasController');
    Route::resource('empresas', 'EmpresasController', ['parameters' => ['empresas' => 'empresa']]);
    Route::get('empresas/pessoa/fisica/create', 'EmpresasController@createPessoaFisica')->name('empresas.pessoa.fisica.create');
    Route::post('empresas/pessoa/fisica/store', 'EmpresasController@storePessoaFisica')->name('empresas.pessoa.fisica.store');
    Route::match(['put', 'patch'], 'empresas/pessoa/fisica/{empresa}/update', 'EmpresasController@updatePessoaFisica')->name('empresas.pessoa.fisica.update');
    Route::resource('veiculos', 'VeiculosController');
    Route::resource('produtos', 'ProdutosController');
    Route::get('produtos/{produto}/duplicar', 'ProdutosController@duplicate')->name('produtos.duplicate');
});
