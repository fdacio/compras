<?php

namespace App\Rules;

use App\Empresa;
use App\PessoaFisica;
use Illuminate\Contracts\Validation\Rule;

class EmpresaCpf implements Rule
{
    private $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cpf = $value;
        $cpf = str_replace(['.', '-'], '', $cpf);
        $pessoaFisica = PessoaFisica::where('cpf', $cpf)->first();
        if (empty($pessoaFisica)) {
            return true;
        }
        if (!empty($this->id)) {
            return Empresa::where('id_pessoa', $pessoaFisica->id_pessoa)->where('id', '!=', $this->id)->count() == 0;
        } else {
            return Empresa::where('id_pessoa', $pessoaFisica->id_pessoa)->count() == 0;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'CPF informado já cadastrado como empresa.';
    }
}
