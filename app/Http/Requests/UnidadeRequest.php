<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeRequest extends FormRequest
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
        $id = (!empty(request()->get('id'))) ? request()->get('id') : '';

        return [
            'nome' => "required|string|max:80|unique:unidades,nome,{$id}"
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Informe o Nome',
            'nome.max' => 'Nome quantidade máxima de 80 caractéres'            
        ];
    }
}
