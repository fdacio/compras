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
    Route::resource('veiculos', 'VeiculosController');
    Route::resource('produtos', 'ProdutosController');
    
    Route::resource('empresas', 'EmpresasController', ['parameters' => ['empresas' => 'empresa']]);
    Route::get('empresas/pessoa/fisica/create', 'EmpresasController@createPessoaFisica')->name('empresas.pessoa.fisica.create');
    Route::post('empresas/pessoa/fisica/store', 'EmpresasController@storePessoaFisica')->name('empresas.pessoa.fisica.store');
    Route::match(['put', 'patch'], 'empresas/pessoa/fisica/{empresa}/update', 'EmpresasController@updatePessoaFisica')->name('empresas.pessoa.fisica.update');
    
    Route::resource('favorecidos', 'FavorecidosController', ['parameters' => ['favorecidos' => 'favorecido']]);
    Route::get('favorecidos/pessoa/fisica/create', 'FavorecidosController@createPessoaFisica')->name('favorecidos.pessoa.fisica.create');
    Route::post('favorecidos/pessoa/fisica/store', 'FavorecidosController@storePessoaFisica')->name('favorecidos.pessoa.fisica.store');
    Route::match(['put', 'patch'], 'favorecidos/pessoa/fisica/{favorecido}/update', 'FavorecidosController@updatePessoaFisica')->name('favorecidos.pessoa.fisica.update');

    Route::get('produtos/{produto}/duplicar', 'ProdutosController@duplicate')->name('produtos.duplicate');
    
    Route::resource('requisicoes-compras', 'RequisicoesComprasController', ['parameters' => ['requisicoes-compras' => 'requisicao']]);
    Route::get('requisicoes-compras/item/create/{requisicao}', 'RequisicoesComprasController@itemCreate')->name('requisicoes-compras.item.create');
    Route::post('requisicoes-compras/item/store/{requisicao}', 'RequisicoesComprasController@itemStore')->name('requisicoes-compras.item.store');
    Route::get('requisicoes-compras/gera-pdf/{requisicao}', 'RequisicoesComprasController@geraPdf')->name('requisicoes-compras.gera.pdf');
    Route::delete('requisicoes-compras/{requisicao}/del-item', 'RequisicoesComprasController@destroyItem')->name('requisicoes-compras.del-item.destroy');

    Route::resource('autorizacoes-pagamentos', 'AutorizacoesPagamentosController', ['parameters' => ['autorizacoes-pagamentos' => 'autorizacao']]);
    Route::get('autorizacoes-pagamentos/item/create/{autorizacao}', 'AutorizacoesPagamentosController@itemCreate')->name('autorizacoes-pagamentos.item.create');
    Route::post('autorizacoes-pagamentos/item/store/{autorizacao}', 'AutorizacoesPagamentosController@itemStore')->name('autorizacoes-pagamentos.item.store');
    Route::get('autorizacoes-pagamentos/gera-pdf/{autorizacao}', 'AutorizacoesPagamentosController@geraPdf')->name('autorizacoes-pagamentos.gera.pdf');
    Route::delete('autorizacoes-pagamentos/{autorizacao}/del-item', 'AutorizacoesPagamentosController@destroyItem')->name('autorizacoes-pagamentos.del-item.destroy');

    Route::get('autorizacoes-pagamentos/documentos/create/{autorizacao}', 'AutorizacoesPagamentosController@documentoCreate')->name('autorizacoes-pagamentos.documentos.create');
    Route::post('autorizacoes-pagamentos/documentos/upload', 'AutorizacoesPagamentosController@documentoUpload')->name('autorizacoes-pagamentos.documentos.upload');
    Route::get('autorizacoes-pagamentos/documentos/download/{documento}', 'AutorizacoesPagamentosController@documentoDownload')->name('autorizacoes-pagamentos.documentos.download');
    Route::delete('autorizacoes-pagamentos/documentos/destroy/{documento}', 'AutorizacoesPagamentosController@documentoDestroy')->name('autorizacoes-pagamentos.documentos.destroy');
});
