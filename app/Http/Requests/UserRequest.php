<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $rules = [
            'id_tipo' => 'required|integer',
            'name' => 'required|string|max:60'
        ];

        if ($this->method() == 'POST') {
            $rules['email'] = 'required|email|max:100|unique:users,email';
            $rules['password'] = 'required|min:6|max:255|confirmed';
            $rules['password_confirmation'] = 'required|min:6|max:255';
        } elseif ($this->method() == 'PUT') {
            $rules = [
                'password' => 'required|min:6|max:255|confirmed',
                'password_confirmation' => 'required|min:6|max:255'
            ];
        } else if ($this->method() == 'PATCH') {
            $rules['email'] = [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($this->user->id)
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'id_tipo.required' => 'O campo tipo é obrigatório.',
            'name.required' => 'O campo nome é obrigatório',
            'password.required' => 'O campo senha é obrigatório',
            'password.confirmed' => 'O campo confirmar senha não confere.',
            'password_confirmation.required' => 'O campo confirmar senha é obrigatório.',
            'password_confirmation.min' => 'O campo confirmar senha deve ter pelo menos 6 caracteres.',
            'password_confirmation.max' => 'O campo confirmar senha não pode ser superior a 255 caracteres.'
        ];
    }
}