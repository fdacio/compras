<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CentroCustoRequest extends FormRequest
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
            'nome' => 'required|string|max:80',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Informe o Nome',
            'nome.max' => 'Nome quantidade máxima de 80 caractéres',
        ];
    }
}
