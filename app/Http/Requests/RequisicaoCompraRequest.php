<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequisicaoCompraRequest extends FormRequest
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
            'tipo' => 'required|string',
            'id_requisitante' => 'required|integer',
            'id_solicitante' => 'required|integer',
            'id_veiculo' => 'nullable|integer',
            'local_entrega' => 'nullable|string',
            'observacao' => 'nullable|string',
        ];
    }


    public function messages()
    {
        return [
            'tipo.required' => 'Informe o Tipo',
            'id_requisitante.required' => 'Informe o Requisitante',
            'id_solicitante.required' => 'Informe o Solicitante',
        ];
    }


    
}
