<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class AutorizacaoPagamentoItemRequest extends FormRequest
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
        return [
            'item' => 'nullable|integer',
            'descricao' => 'required|string|max:200',
            'unidade' => 'nullable|string|max:10',
            'quantidade' => 'nullable|integer',
            'id_veiculo' => 'nullable|integer',
            'id_produto' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.string' => 'O campo descrição deve ser uma string.',
            'descricao.max' => 'O campo descrição deve ter no máximo 200 caracteres.',
        ];
    }
}