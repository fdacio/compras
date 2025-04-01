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
            'quantidade_solicitada' => 'required|integer',
            'quantidade_a_cotar' => 'required|integer'
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
            'quantidade_solicitada.required' => 'O campo quantidade solicitada é obrigatório.',
            'quantidade_solicitada.integer' => 'O campo quantidade solicitada deve ser um número inteiro.',
            'quantidade_a_cotar.required' => 'O campo quantidade a cotar é obrigatório.',
            'quantidade_a_cotar.integer' => 'O campo quantidade a cotar deve ser um número inteiro.'
        ];
    }
}