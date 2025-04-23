<?php

namespace App\Http\Requests;

use App\Rules\EmpresaCnpj;
use Illuminate\Foundation\Http\FormRequest;

class FornecedorPessoaJuridicaRequest extends FormRequest
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
            'cnpj' => ["required", "cnpj", "max:18", new EmpresaCnpj($id)],
            'razao_social' => 'required|string|max:80',
            'cgf' => 'nullable|string|max:20',
            'nome_fantasia' => 'required|string|max:80',
            'cep' => 'nullable|string|max:10',
            'logradouro' => 'nullable|string|max:100',
            'numero' => 'nullable|string|max:10',
            'complemento' => 'nullable|string|max:80',
            'bairro' => 'nullable|string|max:60',
            'id_municipio' => 'nullable|integer',
            'telefone' => 'nullable|string|max:14',
            'celular' => 'nullable|string|max:15',
            'email' => 'nullable|string|max:100',
        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'cnpj.required' => 'Informe o CNPJ',
            'cnpj.max' => 'CNPJ quantidade máxima de 18 caractéres',
            'razao_social.required' => 'Informe a Razão Social',
            'razao_social.max' => 'Razão Social quantidade máxima de 80 caractéres',
            'cgf.max' => 'CGF quantidade máxima de 20 caractéres',
            'nome_fantasia.required' => 'Informe o Nome de Fantasia',
            'nome_fantasia.max' => 'Nome de Fantasia quantidade máxima de 80 caractéres',
            'cep.required' => 'Informe o CEP',
            'cep.max' => 'CEP quantidade máxima de 10 caracteres',
            'logradouro.required' => 'Informe o Logradouro',
            'logradouro.max' => 'Logradouro quantidade máxima de 100 caracteres',
            'numero.required' => 'Informe o Número',
            'numero.max' => 'Número quantidade máxima de 10 caracteres',
            'bairro.required' => 'Informe o Bairro',
            'bairro.max' => 'Bairro quantidade máxima de 60 caracteres',
            'id_municipio.required' => 'Informe a Cidade',
            'telefone.max' => 'Telefone quantidade máxima de 14 caracteres',
            'ponto_referencia.max' => 'Ponto de Referência quantidade máxima de 100 caracteres',
            'celular.max' => 'Celular quantidade máxima de 15 caracteres',
            'email.max' => 'Email quantidade máxima de 100 caracteres',
        ];
    }
    
}
