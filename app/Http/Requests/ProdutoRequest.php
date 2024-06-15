<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
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
        return [
            'nome' => ["required", "string", "max:150"],
            'descricao' => 'nullable|string',
            'valor_unitario' => 'required',
            'id_unidade' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Informe o Nome',
            'nome.max' => 'Nome quantidade máxima de 150 caractéres',
            'valor_unitario.required' => 'Informe o Valor Unitário',
            'id_unidade.required' => 'Informe a Unidade',
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
