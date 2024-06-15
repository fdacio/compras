<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('{uf}/cidades', 'Api\CidadesController')->name('api.cidades.show');
Route::get('cep/{numero}', 'Api\CepController@getDados')->name('api.cep.show');
Route::get('cnpj/{cnpj}', 'Api\PessoasJuridicasController@getDados')->name('api.pessoasjuridicas.cnpj');
Route::get('cpf/{cpf}', 'Api\PessoasFisicasController@getDados')->name('api.pessoasfisicas.cpf');
Route::get('empresas/{cnpjcpf}', 'Api\EmpresasController@empresa')->name('api.empresas.cnpjcpf');
Route::get('empresas', 'Api\EmpreasController@empresas')->name('api.empresas');
Route::post('unidades/store', 'Api\UnidadesController@store')->name('api.unidades.store');
