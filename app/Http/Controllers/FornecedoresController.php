<?php

namespace App\Http\Controllers;

use App\Fornecedor;
use App\Http\Requests\FornecedorPessoaJuridicaRequest;
use App\Http\Requests\FornecedorPessoaFisicaRequest;
use App\Pessoa;
use App\PessoaFisica;
use App\PessoaJuridica;
use App\Uf;
use App\Municipio;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FornecedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fornecedores = Fornecedor::orderBy('id', 'asc');
        $tipoPessoa = request()->get('pessoa');

        if ($tipoPessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
            $cnpj = request()->get('cpf_cnpj');
            $razaoSocial = request()->get('nome_razao_social');
            if (!empty($cnpj)) {
                $cnpj = str_replace(['.', '-', '/'], '', $cnpj);
                $fornecedores = $fornecedores->whereHas('pessoa', function ($query) use ($cnpj) {
                    $query->whereHas('pessoaJuridica', function ($query) use ($cnpj) {
                        $query->where('cnpj', $cnpj);
                    });
                });
            }
            if (!empty($razaoSocial)) {
                $fornecedores = $fornecedores->whereHas('pessoa', function ($query) use ($razaoSocial) {
                    $query->whereHas('pessoaJuridica', function ($query) use ($razaoSocial) {
                        $query->where('razao_social', 'LIKE', '%' . $razaoSocial . '%');
                    });
                });
            }
        }

        if ($tipoPessoa == Pessoa::TIPO_PESSOA_FISICA) {
            $cpf = request()->get('cpf_cnpj');
            $nome = request()->get('nome_razao_social');
            if (!empty($cpf)) {
                $cpf = str_replace(['.', '-'], '', $cpf);
                $fornecedores = $fornecedores->whereHas('pessoa', function ($query) use ($cpf) {
                    $query->whereHas('pessoaFisica', function ($query) use ($cpf) {
                        $query->where('cpf', $cpf);
                    });
                });
            }
            if (!empty($nome)) {
                $fornecedores = $fornecedores->whereHas('pessoa', function ($query) use ($nome) {
                    $query->whereHas('pessoaFisica', function ($query) use ($nome) {
                        $query->where('nome', 'LIKE', '%' . $nome . '%');
                    });
                });
            }
        }

        $fornecedores = $fornecedores->paginate(10);
        return view('fornecedores.index', compact('fornecedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Uf::pluck('sigla', 'id');
        $cidades = [];
        return view('fornecedores.create', compact('estados', 'cidades'));
    }

    public function createPessoaFisica()
    {
        $estados = Uf::pluck('sigla', 'id');
        $cidades = [];
        return view('fornecedores.pessoas-fisicas.create', compact('estados', 'cidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FornecedorPessoaJuridicaRequest $request)
    {
        try {

            DB::beginTransaction();

            $cnpj = $request->get('cnpj');
            $cnpj = str_replace(['.', '-', '/'], '', $cnpj);

            $pessoaJuridica = PessoaJuridica::where('cnpj', $cnpj)->first();
            if (empty($pessoaJuridica)) {
                $pessoa = Pessoa::create(array_merge(['tipo_pessoa' => Pessoa::TIPO_PESSOA_JURIDICA], $request->all()));
                $pessoaJuridica = $pessoa->pessoaJuridica()->create($request->all());
            }

            $dadosFornecedor = [
                'id_pessoa' => $pessoaJuridica->id_pessoa,
            ];

            $dadosFornecedor = array_merge($dadosFornecedor, $request->all());
            Fornecedor::create($dadosFornecedor);

            DB::commit();
            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor cadastrado com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('fornecedores.index')->withInput()->with('danger', 'Error:' . $e->getMessage());
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Fornecedor $fornecedor)
    {
        if ($fornecedor->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
            return view('fornecedores.show', compact('fornecedor'));
        }
        if ($fornecedor->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_FISICA) {
            return view('fornecedores.pessoas-fisicas.show', compact('fornecedor'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Fornecedor $fornecedor)
    {
        $estados = Uf::pluck('sigla', 'id');
        if ($fornecedor->pessoa->cidade) {
            $cidades = Municipio::where('id_uf', $fornecedor->pessoa->cidade->id)->pluck('nome', 'id');
        } else {
            $cidades = [];
        }
        if ($fornecedor->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
            return view('fornecedores.edit', compact('fornecedor', 'estados', 'cidades'));
        }
        if ($fornecedor->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_FISICA) {
            return view('fornecedores.pessoas-fisicas.edit', compact('fornecedor', 'estados', 'cidades'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FornecedorPessoaJuridicaRequest $request, Fornecedor $fornecedor)
    {
        $fornecedor->update($request->all());
        $fornecedor->pessoa()->update($request->all());
        $pessoaJuridica = $fornecedor->pessoa->pessoaJuridica()->first();
        $pessoaJuridica->update($request->all());
        return redirect()->route('fornecedores.index')->with('success', 'Cadastro de Fornecedor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fornecedor $fornecedor)
    {
        try {
            $fornecedor->delete();
            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor excluído com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('fornecedores.index')->with('danger', 'Não foi possível excluir o fornecedor!');
        }
    }

    public function storePessoaFisica(FornecedorPessoaFisicaRequest $request)
    {
        try {
            DB::beginTransaction();
            $cpf = $request->get('cpf');
            $cpf = str_replace(['.', '-'], '', $cpf);

            $pessoaFisica = PessoaFisica::where('cpf', $cpf)->first();
            if (empty($pessoaFisica)) {
                $pessoa = Pessoa::create(array_merge(['tipo_pessoa' => Pessoa::TIPO_PESSOA_FISICA], $request->all()));
                $pessoaFisica = $pessoa->pessoaFisica()->create($request->all());
            }
            $dadosFornecedor = [
                'id_pessoa' => $pessoaFisica->id_pessoa,
            ];

            $dadosFornecedor = array_merge($dadosFornecedor, $request->all());
            Fornecedor::create($dadosFornecedor);

            DB::commit();
            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor cadastrado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('fornecedores.pessoa.fisica.create')->withInput()->with('danger', 'Error:' . $e->getMessage());
            DB::rollback();
        }
    }

    public function updatePessoaFisica(FornecedorPessoaFisicaRequest $request, Fornecedor $fornecedor)
    {
        $fornecedor->update($request->all());
        $fornecedor->pessoa->update($request->all());
        $pessoaFisica = $fornecedor->pessoa->PessoaFisica()->first();
        $pessoaFisica->update($request->all());
        return redirect()->route('fornecedores.index')->with('success', 'Cadastro do Fornecedor alterado com sucesso');
    }
}
