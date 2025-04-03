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
            'item' => 'required|integer',
            'descricao' => 'required|string|max:200',
            'unidade' => 'required|string|max:10',
            'quantidade' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'item.required' => 'O campo item é obrigatório.',
            'item.integer' => 'O campo item deve ser um número inteiro.',
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.string' => 'O campo descrição deve ser uma string.',
            'descricao.max' => 'O campo descrição deve ter no máximo 200 caracteres.',
            'unidade.required' => 'O campo unidade é obrigatório.',
            'unidade.string' => 'O campo unidade deve ser uma string.',
            'unidade.max' => 'O campo unidade deve ter no máximo 10 caracteres.',
            'quantidade.required' => 'O campo quantidade é obrigatório.',
            'quantidade.integer' => 'O campo quantidade deve ser um número inteiro.',
        ];
    }
}