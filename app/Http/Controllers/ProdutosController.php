<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Produto;
use App\Unidade;
use Exception;

use function Psy\debug;

class ProdutosController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::orderBy('nome', 'asc');
        $id = request()->get('id');
        $nome = request()->get('nome');

        if (!empty($id)) {
            $produtos =  $produtos->where('id', $id);
        }
        if (!empty($nome)) {
            $produtos =  $produtos->where('nome', 'LIKE', '%' . $nome . '%');
        }
        $produtos = $produtos->paginate(10);
        return view('produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidades = Unidade::orderBy('nome', 'asc')->pluck('nome', 'id');
        return view('produtos.create', compact('unidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutoRequest $request)
    {
        $produto = Produto::create($request->all());
        return redirect()->route('produtos.index', $produto->id)->with('success', 'Produto cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Produto $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
         return view('produtos.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Produto $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        $unidades = Unidade::orderBy('nome', 'asc')->pluck('nome', 'id');
        return view('produtos.edit', compact('produto', 'unidades' ));
    }

    /**
     * Show the form for duplicate the specified resource
     * 
     * @param Produto $produto
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Produto $produto)
    {
        $unidades = Unidade::orderBy('nome', 'asc')->pluck('nome', 'id');
        return view('produtos.duplicate', compact('produto', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutoRequest $request, Produto $produto)
    {
        $produto->update($request->all());
        return redirect()->route('produtos.index', $produto->id)->with('success', 'Cadastro de Produto alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Produto $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        try {
            $produto->delete();
            return redirect()->route('produtos.index')->with('success', 'Cadastro de Produto excluído com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('produtos.index')->with('danger', 'Não foi possível excluir o cadastro de produto. Há vínculos');
        }
    }

}
