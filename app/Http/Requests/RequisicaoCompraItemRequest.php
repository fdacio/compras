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
                'quantidade_solicitada' => 'required|integer|min:1',
            ];
        }

        if ($requisicao->tipo == 'SERVICO') {
            return [
                'servico' => 'required|string|max:200',
                'quantidade_solicitada' => 'required|integer|min:1',
            ];
        }

        return [];
    }

    public function messages()
    {
        return [
            'servico.required' => 'Informe a descrição do serviço.',
            'servico.max' => 'O campo descrição do serviço máximo 200 caracteres.',
            'id_produto.required' => 'Informe o produto.',
            'quantidade_solicitada.required' => 'Informe a quantidade solicitada.',
            'quantidade_solicitada.integer' => 'Quantidade solicitada inválida.',
            'quantidade_solicitada.min' => 'Quantidade solicitada inválida.',
        ];
    }
}
