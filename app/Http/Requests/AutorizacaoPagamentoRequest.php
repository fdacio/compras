<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutorizacaoPagamentoRequest extends FormRequest
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
            'id_favorecido' => 'required|integer',
            'id_municipio' => 'required|integer',
            'id_veiculo' => 'required|integer',
            'id_forma_pagamento' => 'required|integer',
            'valor' => 'required|numeric|between:0.00001,99999999999.9999',
            'observacao' => 'nullable|string',
            'banco' => 'nullable|string|max:60',
            'agencia' => 'nullable|string|max:20',
            'conta' => 'nullable|string|max:30',
            'operacao' => 'nullable|string|max:30',
            'chave_pix' => 'nullable|string|max:30',    
        ];
    }


    public function messages()
    {
        return [
            'id_favorecido.required' => 'Informe o Favorecido',
            'id_municipio.required' => 'Informe o Municipio',
            'id_veiculo.required' => 'Informe o Veículo',
            'id_forma_pagamento.required' => 'Informe a Forma de Pagamento',
            'valor.required' => 'Informe o Valor',
            'valor.numeric' => 'Valor Inválido',
            'valor.between' => 'Valor Inválido',
            'observacao.string' => 'Observação deve ser texto',
            'observacao.max' => 'Observação deve ter no máximo 500 caracteres',
            'banco.string' => 'Banco deve ser texto',
            'banco.max' => 'Banco deve ter no máximo 60 caracteres',
            'agencia.string' => 'Agência deve ser texto',
            'agencia.max' => 'Agência deve ter no máximo 20 caracteres',
            'conta.string' => 'Conta deve ser texto',
            'conta.max' => 'Conta deve ter no máximo 30 caracteres',
            'operacao.string' => 'Operação deve ser texto',
            'operacao.max' => 'Operação deve ter no máximo 30 caracteres',
            'chave_pix.string' => 'Chave PIX deve ser texto',
            'chave_pix.max' => 'Chave PIX deve ter no máximo 30 caracteres',
        ];
    }


    protected function prepareForValidation()
    {
        $valor = str_replace('R$', '', $this->valor);
        $valor = str_replace(' ', '', $valor);
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);

        $this->merge([
            'valor' => $valor
        ]);
    }

}
