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


Route::group(['middleware' => ['auth', 'auth.access', 'check.permissao']], function () {
    
    Route::resource('user', 'UserController');
    Route::put('user/{user}/desativar', 'UserController@desativar')->name('user.desativar');
    Route::get('user/centros-custos/{user}/edit', 'UserController@centrosCustosEdit')->name('user.centros-custos.edit');
    Route::put('user/centros-custos/{user}/update', 'UserController@centrosCustosUpdate')->name('user.centros-custos.update');

    Route::resource('tipos-usuarios', 'TiposUsuariosController');

    Route::resource('centros-custos', 'CentrosCustosController');
    Route::resource('solicitantes', 'SolicitantesController');
    Route::resource('frotas', 'FrotasController');
    Route::resource('veiculos', 'VeiculosController');
    Route::resource('produtos', 'ProdutosController');
    
    Route::resource('empresas', 'EmpresasController', ['parameters' => ['empresas' => 'empresa']]);
    Route::get('empresas/pessoa/fisica/create', 'EmpresasController@createPessoaFisica')->name('empresas.pessoa.fisica.create');
    Route::post('empresas/pessoa/fisica/store', 'EmpresasController@storePessoaFisica')->name('empresas.pessoa.fisica.store');
    Route::match(['put', 'patch'], 'empresas/pessoa/fisica/{empresa}/update', 'EmpresasController@updatePessoaFisica')->name('empresas.pessoa.fisica.update');
    
    Route::resource('fornecedores', 'FornecedoresController', ['parameters' => ['fornecedores' => 'fornecedor']]);
    Route::get('fornecedores/pessoa/fisica/create', 'FornecedoresController@createPessoaFisica')->name('fornecedores.pessoa.fisica.create');
    Route::post('fornecedores/pessoa/fisica/store', 'FornecedoresController@storePessoaFisica')->name('fornecedores.pessoa.fisica.store');
    Route::match(['put', 'patch'], 'fornecedores/pessoa/fisica/{fornecedor}/update', 'FornecedoresController@updatePessoaFisica')->name('fornecedores.pessoa.fisica.update');

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
    Route::match(['PUT', 'PATCH'], 'requisicoes-compras/{requisicao}/cancelar', 'RequisicoesComprasController@cancelar')->name('requisicoes-compras.cancelar');
    Route::match(['PUT', 'PATCH'], 'requisicoes-compras/{requisicao}/autorizar', 'RequisicoesComprasController@autorizar')->name('requisicoes-compras.autorizar');
    Route::match(['PUT', 'PATCH'], 'requisicoes-compras/{requisicao}/cotar', 'RequisicoesComprasController@cotar')->name('requisicoes-compras.cotar');
    Route::get('requisicoes-compras/{requisicao}/cotacao/edit', 'RequisicoesComprasController@cotacaoEdit')->name('requisicoes-compras.cotacao.edit');
    Route::get('requisicoes-compras/{requisicao}/cotacao/show', 'RequisicoesComprasController@cotacaoShow')->name('requisicoes-compras.cotacao.show');
    Route::get('requisicoes-compras/cotadas/autorizacoes', 'RequisicoesComprasController@cotadasAutorizacoes')->name('requisicoes-compras.cotadas.autorizacoes');


    Route::get('cotacoes', 'CotacoesController@index')->name('cotacoes.index');
    Route::get('cotacoes/{cotacao}', 'CotacoesController@show', ['parameters' => ['cotacoes' => 'cotacao']])->name('cotacoes.show');
    Route::delete('cotacoes/{cotacao}', 'CotacoesController@destroy', ['parameters' => ['cotacoes' => 'cotacao']])->name('cotacoes.destroy');
    Route::get('cotacoes/{cotacao}/edit', 'CotacoesController@edit', ['parameters' => ['cotacoes' => 'cotacao']])->name('cotacoes.edit');
    Route::post('cotacoes/{cotacao}/fornecedor', 'CotacoesController@storeFornecedor', ['parameters' => ['cotacoes' => 'cotacao']])->name('cotacoes.fornecedor.store');   
    Route::delete('cotacoes/fornecedor/{cotacao}', 'CotacoesController@destroyFornecedor', ['parameters' => ['cotacoes' => 'cotacao']])->name('cotacoes.fornecedor.destroy');   
    Route::match(['PUT', 'PATCH'],'cotacoes/update/{cotacao}', 'CotacoesController@update', ['parameters' => ['cotacoes' => 'cotacao']])->name('cotacoes.update');
    Route::match(['PUT', 'PATCH'],'cotacoes/finaliza/{cotacao}', 'CotacoesController@finalizar', ['parameters' => ['cotacoes' => 'cotacao']])->name('cotacoes.finalizar');
    Route::get('cotacoes/gera-pdf/{cotacao}', 'CotacoesController@geraPdf')->name('cotacoes.gera.pdf');


    Route::resource('autorizacoes-pagamentos', 'AutorizacoesPagamentosController', ['parameters' => ['autorizacoes-pagamentos' => 'autorizacao']]);
    Route::get('autorizacoes-pagamentos/item/create/{autorizacao}', 'AutorizacoesPagamentosController@itemCreate')->name('autorizacoes-pagamentos.item.create');
    Route::post('autorizacoes-pagamentos/item/store/{autorizacao}', 'AutorizacoesPagamentosController@itemStore')->name('autorizacoes-pagamentos.item.store');
    Route::get('autorizacoes-pagamentos/gera-pdf/{autorizacao}', 'AutorizacoesPagamentosController@geraPdf')->name('autorizacoes-pagamentos.gera.pdf');
    Route::match(['PUT', 'PATCH'], 'autorizacoes-pagamentos/{autorizacao}/autorizar', 'AutorizacoesPagamentosController@autorizar')->name('autorizacoes-pagamentos.autorizar');
    Route::delete('autorizacoes-pagamentos/{autorizacao}/del-item', 'AutorizacoesPagamentosController@destroyItem')->name('autorizacoes-pagamentos.del-item.destroy');

    Route::get('autorizacoes-pagamentos/documentos/create/{autorizacao}', 'AutorizacoesPagamentosController@documentoCreate')->name('autorizacoes-pagamentos.documentos.create');
    Route::post('autorizacoes-pagamentos/documentos/upload', 'AutorizacoesPagamentosController@documentoUpload')->name('autorizacoes-pagamentos.documentos.upload');
    Route::get('autorizacoes-pagamentos/documentos/download/{documento}', 'AutorizacoesPagamentosController@documentoDownload')->name('autorizacoes-pagamentos.documentos.download');
    Route::delete('autorizacoes-pagamentos/documentos/destroy/{documento}', 'AutorizacoesPagamentosController@documentoDestroy')->name('autorizacoes-pagamentos.documentos.destroy');
});

Route::group(['middleware' => ['auth']], function () {
    /**Requisições de compras externas */
    Route::resource('requisicoes-compras-externas', 'RequisicoesComprasExternasController', ['parameters' => ['requisicoes-compras-externas' => 'requisicao']]);
    Route::get('requisicoes-compras-externas/item/create/{requisicao}', 'RequisicoesComprasExternasController@itemCreate')->name('requisicoes-compras-externas.item.create');
    Route::post('requisicoes-compras-externas/item/store/{requisicao}', 'RequisicoesComprasExternasController@itemStore')->name('requisicoes-compras-externas.item.store');
    Route::get('requisicoes-compras-externas/gera-pdf/{requisicao}', 'RequisicoesComprasExternasController@geraPdf')->name('requisicoes-compras-externas.gera.pdf');
    Route::delete('requisicoes-compras-externas/{requisicao}/del-item', 'RequisicoesComprasExternasController@destroyItem')->name('requisicoes-compras-externas.del-item.destroy');
    Route::match(['PUT', 'PATCH'], 'requisicoes-compras-externas/{requisicao}/cancelar', 'RequisicoesComprasExternasController@cancelar')->name('requisicoes-compras-externas.cancelar');

});