<?php

namespace App\Http\Requests;

use App\RequisicaoCompra;
use Illuminate\Foundation\Http\FormRequest;


class RequisicaoCompraItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = request('id_requisicao');
        $requisicao = RequisicaoCompra::find($id);
        
        if ($requisicao->tipo == 'PRODUTO') {  
            return [
                'id_produto' => 'required|integer',
                'quantidade_solicitada' => 'required|integer',
                'quantidade_a_cotar' => 'required|integer'
            ];

        } 
        
        if ($requisicao->tipo == 'SERVICO') {  
            return [
                'descricao' => 'required|string|max:200',
                'quantidade_solicitada' => 'required|integer',
                'quantidade_a_cotar' => 'required|integer'
            ];
        }

        return [];
    }

    public function messages()
    {
        return [
            'descricao.required' => 'Informe a descrição do serviço.',
            'descricao.max' => 'O campo descrição do serviço máximo 200 caracteres.',
            'id_produto.required' => 'Informe o produto.',
            'quantidade_solicitada.required' => 'O campo quantidade solicitada é obrigatório.',
            'quantidade_solicitada.integer' => 'O campo quantidade solicitada deve ser um número inteiro.',
            'quantidade_a_cotar.required' => 'O campo quantidade a cotar é obrigatório.',
            'quantidade_a_cotar.integer' => 'O campo quantidade a cotar deve ser um número inteiro.'
        ];
    }
}