<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FavorecidoPessoaFisicaRequest extends FormRequest
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
        $id = request()->get('id');

        $rules = [         
            'cpf' => ["required", "cpf", "max:14"],
            'nome' => 'required|string|max:80',
            'nascimento' => 'nullable|date_format:d/m/Y',
            'rg_emissao' => 'nullable|date_format:d/m/Y',
            'cep' => 'required|string|max:10',
            'logradouro' => 'required|string|max:100',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:80',
            'ponto_referencia' => 'nullable|string|max:100',
            'bairro' => 'required|string|max:60',
            'id_municipio' => 'required|integer',
            'telefone' => 'nullable|string|max:14',
            'celular' => 'nullable|string|max:15',
            'email' => 'nullable|string|max:100',

        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'cpf.required' => 'Informe o CPF',
            'cpf.max' => 'CPF quantidade máxima de 18 caractéres',
            'nome.required' => 'Informe o Nome',
            'nome.max' => 'Nome quantidade máxima de 80 caractéres',
            'nascimento.date_format' => 'Data de Nascimento inválida',
            'rg_emissao.date_format' => 'Data Emissão RG inválida',
            'cep.required' => 'Informe o CEP',
            'cep.max' => 'CEP quantidade máxima de 10 caracteres',
            'logradouro.required' => 'Informe o Logradouro',
            'logradouro.max' => 'Logradouro quantidade máxima de 100 caracteres',
            'numero.required' => 'Informe o Número',
            'numero.max' => 'Número quantidade máxima de 10 caracteres',
            'bairro.required' => 'Informe o Bairro',
            'bairro.max' => 'Bairro quantidade máxima de 60 caracteres',
            'id_municipio.required' => 'Informe a Cidade',
            'ponto_referencia.max' => 'Ponto de Referência quantidade máxima de 100 caracteres',
            'telefone.max' => 'Telefone quantidade máxima de 14 caracteres',
            'celular.max' => 'Celular quantidade máxima de 15 caracteres',
            'email.max' => 'Email quantidade máxima de 100 caracteres',
        ];
    }

}
