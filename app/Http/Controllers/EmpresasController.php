<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Http\Requests\EmpresaRequest;
use App\Municipio;
use App\Pessoa;
use App\PessoaFisica;
use App\PessoaJuridica;
use App\Uf;
use Exception;
use Illuminate\Support\Facades\DB;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::orderBy('id', 'asc');
        $tipoPessoa = request()->get('pessoa');
        
        if ($tipoPessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
            $cnpj = request()->get('cpf_cnpj');
            $razaoSocial = request()->get('nome_razao_social');
            if (!empty($cnpj)) {
                $cnpj = str_replace(['.', '-', '/'], '', $cnpj);
                $empresas =  $empresas->whereHas('pessoa', function ($query) use ($cnpj) {
                    $query->whereHas('pessoaJuridica',  function ($query) use ($cnpj) {
                        $query->where('cnpj', $cnpj);
                    });
                });
            }
            if (!empty($razaoSocial)) {
                $empresas =  $empresas->whereHas('pessoa', function ($query) use ($razaoSocial) {
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
                $empresas =  $empresas->whereHas('pessoa', function ($query) use ($cpf) {
                    $query->whereHas('pessoaFisica',  function ($query) use ($cpf) {
                        $query->where('cpf', $cpf);
                    });
                });
            }
            if (!empty($nome)) {
                $empresas =  $empresas->whereHas('pessoa', function ($query) use ($nome) {
                    $query->whereHas('pessoaFisica', function ($query) use ($nome) {
                        $query->where('nome', 'LIKE', '%' . $nome . '%');
                    });
                });
            }
        }

        $empresas = $empresas->paginate(10);
        return view('empresas.index', compact('empresas'));
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
        return view('empresas.create', compact('estados', 'cidades'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPessoaFisica()
    {
        $estados = Uf::pluck('sigla', 'id');
        $cidades = [];
        return view('empresas.pessoas-fisicas.create', compact('estados', 'cidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpresaRequest $request)
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

            $dadosEmpresa = [
                'id_pessoa' => $pessoaJuridica->id_pessoa,
            ];

            $dadosEmpresa = array_merge($dadosEmpresa, $request->all());
            Empresa::create($dadosEmpresa);

            DB::commit();
            return redirect()->route('empresas.index')->with('success', 'Empresa cadastrado com sucesso.');

        } catch (Exception $e) {
            return redirect()->route('empresas.create')->withInput()->with('danger', 'Error:' . $e->getMessage());
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        if ($empresa->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
            return view('empresas.show', compact('empresa'));
        }
        if ($empresa->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_FISICA) {
            return view('empresas.pessoas-fisicas.show', compact('empresa'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        $estados = Uf::pluck('sigla', 'id');
        $cidades = Municipio::where('id_uf', $empresa->pessoa->cidade->estado->id)->pluck('nome', 'id');
        if ($empresa->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
            return view('empresas.edit', compact('empresa', 'estados', 'cidades'));
        }
        if ($empresa->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_FISICA) {
            return view('empresas.pessoas-fisicas.edit', compact('empresa', 'estados', 'cidades'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmpresaRequest $request, Empresa $empresa)
    {
        $empresa->update($request->all());
        $empresa->pessoa()->update($request->all());
        $pessoaJuridica = $empresa->pessoa->pessoaJuridica()->first();
        $pessoaJuridica->update($request->all());
        return redirect()->route('empresas.index')->with('success', 'Cadastro de Empresa alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        try {
            $empresa->delete();
            return redirect()->route('empresas.index')->with('success', 'Cadastro de empresa excluído com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('empresas.index')->with('danger', 'Não é possível excluir empresa. Há vínculos');
        }
    }

    /**
     * Store para pessoa fisica
     
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePessoaFisica(EmpresaRequest $request)
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
            $dadosEmpresa = [
                'id_pessoa' => $pessoaFisica->id_pessoa,
            ];

            $dadosEmpresa = array_merge($dadosEmpresa, $request->all());
            Empresa::create($dadosEmpresa);

            DB::commit();
            return redirect()->route('empresas.index')->with('success', 'Empresa cadastrado com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('empresas.pessoa.fisica.create')->withInput()->with('danger', 'Error:' . $e->getMessage());
            DB::rollback();
        }
    }

    public function updatePessoaFisica(EmpresaRequest $request, Empresa $empresa)
    {
        $empresa->update($request->all());
        $empresa->pessoa->update($request->all());
        $pessoaFisica = $empresa->pessoa->pessoaFisica()->first();
        $pessoaFisica->update($request->all());
        return redirect()->route('empresas.index')->with('success', 'Cadastro de Empresa alterado com sucesso.');
    }

}
