<?php

namespace App\Rules;

use App\Empresa;
use App\PessoaJuridica;
use Illuminate\Contracts\Validation\Rule;

class EmpresaCnpj implements Rule
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
        $cnpj = $value;
        $cnpj = str_replace(['.', '-', '/'], '', $cnpj);
        $pessoaJuridica = PessoaJuridica::where('cnpj', $cnpj)->first();
        if (empty($pessoaJuridica)) {
            return true;
        }
        if (!empty($this->id)) {
            return Empresa::where('id_pessoa', $pessoaJuridica->id_pessoa)->where('id', '!=', $this->id)->count() == 0;
        } else {
            return Empresa::where('id_pessoa', $pessoaJuridica->id_pessoa)->count() == 0;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'CNPJ informado já cadastrado como empresa.';
    }
}
