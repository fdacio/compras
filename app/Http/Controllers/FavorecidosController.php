<?php

namespace App\Http\Controllers;

Use App\Favorecido;
Use App\Http\Requests\FavorecidoPessoaJuridicaRequest;
Use App\Http\Requests\FavorecidoPessoaFisicaRequest;
Use App\Pessoa;
Use App\PessoaFisica;
Use App\PessoaJuridica;
Use App\Uf;
Use App\Municipio;
Use Exception;
Use Illuminate\Support\Facades\DB;

class FavorecidosController extends Controller
{
      /**
     * Mostrando uma listagem dos recursoso
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        $favorecidos = Favorecido::orderBy('id', 'asc');
        $tipoPessoa = request()->get('pessoa');

        if ($tipoPessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
            $cnpj = request()->get('cpf_cnpj');
            $razaoSocial = request()->get('nome_razao_social');
            if(!empty($cnpj)) {
                $cnpj = str_replace(['.', '-', '/'], '', $cnpj);
                $favorecidos = $favorecidos->whereHas('pessoa', function ($query) use ($cnpj) {
                    $query->whereHas('pessoaJuridica', function ($query) use ($cnpj) {
                        $query->where('cnpj', $cnpj);
                    });
                });
            }
            if(!empty($razaoSocial)) {
                $favorecidos = $favorecidos->whereHas('pessoa', function ($query) use ($razaoSocial) {
                    $query->whereHas('pessoaJuridica', function ($query) use ($razaoSocial) {
                        $query->where('razao_social', 'LIKE', '%' . $razaoSocial . '%');
                    });
                });
            }
        }
    
        if ($tipoPessoa == Pessoa::TIPO_PESSOA_FISICA){
            $cpf = request()->get('cpf_cnpj');
            $nome = request()->get('nome_razao_social');
            if(!empty($cpf)) {
                $cpf = str_replace(['.', '-'], '', $cpf);
                $favorecidos = $favorecidos->whereHas('pessoa', function ($query) use ($cpf) {
                    $query->whereHas('pessoaFisica', function ($query) use ($cpf) {
                        $query->where('cpf', $cpf);
                    });
                });
            }
            if(!empty($nome)) {
                $favorecidos = $favorecidos->whereHas('pessoa', function ($query) use ($nome) {
                    $query->whereHas('pessoaFisica', function ($query) use ($nome) {
                        $query->where('nome', 'LIKE', '%' . $nome . '%');
                    });
                });
            }
        }

        $favorecidos = $favorecidos->paginate(10);
        return view('favorecidos.index', compact('favorecidos'));
    }

    /**
     * Mostrando o formulário para criar um novo recurso
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $estados = Uf::pluck('sigla', 'id');
        $cidades = [];
        return view('favorecidos.create', compact('estados', 'cidades'));
    }

    /**
     * Mostrando o formulário para criar um novo recurso
     *
     * @return \Illuminate\Http\Response
     */
    public function createPessoaFisica()
    {
        $estados = Uf::pluck('sigla', 'id');
        $cidades = [];
        return view('favorecidos.pessoas-fisicas.create', compact('estados', 'cidades'));
    }

    /**
     * Armazenando um recurso recém-criado no armazenamento.
     *
     * @param  \App\Http\Requests\  $request
     * @return \Illuminate\Http\Response
     */

    public function store(FavorecidoPessoaJuridicaRequest $request)
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

            $dadosFavorecido = [
                'id_pessoa' => $pessoaJuridica->id_pessoa,
            ];

            $dadosFavorecido = array_merge($dadosFavorecido, $request->all());
            Favorecido::create($dadosFavorecido);

            DB::commit();
            return redirect()->route('favorecidos.index')->with('success', 'Favorecido cadastrado com sucesso!');

        } catch (Exception $e) {
            return redirect()->route('favorecidos.index')->withInput()->with('danger', 'Error:' . $e->getMessage());
            DB::rollBack();
        }
    }

    public function show(Favorecido $favorecido)
    {
            if ($favorecido->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
                return view('favorecidos.show', compact('favorecido'));
            }
            if ($favorecido->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_FISICA) {
                return view('favorecidos.pessoas-fisicas.show', compact('favorecido'));
            }
    }

    public function edit(Favorecido $favorecido)
    {
        $estados = Uf::pluck('sigla', 'id');
        $cidades = Municipio::where('id_uf', $favorecido->pessoa->cidade->id)->pluck('nome', 'id');
        if ($favorecido->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
            return view('favorecidos.edit', compact('favorecido', 'estados', 'cidades'));
        }
        if ($favorecido->pessoa->tipo_pessoa == Pessoa::TIPO_PESSOA_FISICA) {
            return view('favorecidos.pessoas-fisicas.edit', compact('favorecido', 'estados', 'cidades'));
        }
    }

    public function update(FavorecidoPessoaJuridicaRequest $request, Favorecido $favorecido)
    {
        $favorecido->update($request->all());
        $favorecido->pessoa()->update($request->all());
        $pessoaJuridica = $favorecido->pessoa->pessoaJuridica()->first();
        $pessoaJuridica->update($request->all());
        return redirect()->route('favorecidos.index')->with('success', 'Cadastro de Favorecido atualizado com sucesso!');
    }

    public function destroy(Favorecido $favorecido)
    {
        try {
            $favorecido->delete();
            return redirect()->route('favorecidos.index')->with('success', 'Favorecido excluído com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('favorecidos.index')->with('danger', 'Não foi possível excluir o favorecido!');
        }
    }

    public function storePessoaFisica(FavorecidoPessoaFisicaRequest $request)
    {
        try{
            DB::beginTransaction();
            $cpf = $request->get('cpf');
            $cpf = str_replace(['.', '-'], '', $cpf);

            $pessoaFisica = PessoaFisica::where('cpf', $cpf)->first();
            if (empty($pessoaFisica)) {
                $pessoa = Pessoa::create(array_merge(['tipo_pessoa' => Pessoa::TIPO_PESSOA_FISICA], $request->all()));
                $pessoaFisica = $pessoa->pessoaFisica()->create($request->all());
            }
            $dadosFavorecido = [
                'id_pessoa' =>$pessoaFisica->id_pessoa,
            ];

            $dadosFavorecido = array_merge($dadosFavorecido, $request->all());
            Favorecido::create($dadosFavorecido);

            DB::commit();
            return redirect()->route('favorecidos.indes')->with('sucess' , 'Favorecido cadastrado com sucesso');
        } catch(Exception $e) {
            return redirect()->route('favorecidos.pessoa.fisica.create')->withInput()->with('danger', 'Error:' . $e->getMessage());
            DB::rollback();
        }
    }

    public function updatePessoaFiscia(FavorecidoPessoaFisicaRequest $request, Favorecido $favorecido)
    {
        $favorecido->update($request->all());
        $favorecido->pessoa->update($request->all());
        $pessoaFisica = $favorecido->pessoa->PessoaFisica()->first();
        $pessoaFisica->update($request->all());
        return redirect()->route('favorecidos.index')->with('sucess', 'Cadastro do Favorecido alterado com sucesso');
    }
}
