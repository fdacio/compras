<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotacaoFornecedoItemRequest extends FormRequest
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
            'quantidade_cotada.*' => 'required|numeric|min:0',
            'quantidade_atendida.*' => 'required|numeric|min:0',
            'valor_unitario.*' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'quantidade_cotada.*.required' => 'O campo Quantidade Cotada é obrigatório.',
            'quantidade_atendida.*.required' => 'O campo Quantidade Atendida é obrigatório.',
            'valor_unitario.*.required' => 'O campo Valor Unitário é obrigatório.',
        ];
   }

    protected function prepareForValidation()
    {

        $this->merge([
            'valor_unitario' => $this->parseMoney($this->valor_unitario),
        ]);
    }


    private function parseMoney($valor)
    {
        if (empty($valor)) {
            return 0;
        }
        $valor = str_replace('R$', '', $valor);
        $valor = str_replace(' ', '', $valor);
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        return $valor;
    }

}
