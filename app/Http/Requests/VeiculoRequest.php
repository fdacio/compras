<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeiculoRequest extends FormRequest
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
            'id_empresa' => 'required|integer',
            'id_frota' => 'required|integer',
            'id_centro_custo' => 'required|integer',
            'id_tipo_veiculo' => 'required|integer',
            'marca' => 'required|string|max:30',
            'modelo' => 'required|string|max:30',
            'placa' => 'required|string|max:10',
            'uf' => 'required|string|max:2',
            'cor' => 'required|string|max:20',
            'ano' => 'required|string|max:4',
            'renavan' => 'required|string|max:20'
        ];
    }

    public function messages()
    {
        return [
            'id_empresa.required' => 'Informe a Empresa',
            'id_frota.required' => 'Informe a Fronta',
            'id_centro_custo.required' => 'Informe o Centro de Custo',
            'id_tipo_veiculo.required' => 'Informe o Tipo',
            'marca.required' => 'Informe a Marca',
            'marca.max' => 'Marca quantidade máxima de 30 caractéres',
            'modelo.required' => 'Informe o Modelo',
            'modelo.max' => 'Modelo quantidade máxima de 30 caractéres',
            'placa.required' => 'Informe o Placa',
            'placa.max' => 'Placa quantidade máxima de 20 caractéres',
            'uf.required' => 'Informe a UF',
            'uf.max' => 'UF quantidade máxima de 2 caractéres',
            'cor.required' => 'Informe o Cor',
            'cor.max' => 'Cor quantidade máxima de 20 caractéres',
            'ano.required' => 'Informe o Ano',
            'ano.max' => 'Ano quantidade máxima de 4 caractéres',
            'renavan.required' => 'Informe o Renavan',
            'renavan.max' => 'Renavan quantidade máxima de 20 caractéres',
        ];
    }
}
