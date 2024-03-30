<?php

namespace App\Helpers;

class Formatter
{

    public static function cpf($cpf)
    {
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }

    public static function cnpj($cnpj)
    {
        return substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' .  substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
    }

    public static function cpfCnpj($cpfCnpj)
    {
        if (strlen($cpfCnpj) == 11) {
            return self::cpf($cpfCnpj);
        }

        if (strlen($cpfCnpj) == 14) {
            return self::cnpj($cpfCnpj);
        }

        return $cpfCnpj;
    }

    public static function telefone($telefone)
    {
        return '(' . substr($telefone, 0, 2) . ')' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 4);
    }

    public static function celular($celular)
    {
        if (strlen($celular) == 10) {
            return '(' . substr($celular, 0, 2) . ')' . substr($celular, 2, 4) . '-' . substr($celular, 6, 4);
        }
        if (strlen($celular) == 11) {
            return '(' . substr($celular, 0, 2) . ')' . substr($celular, 2, 1) . ' ' . substr($celular, 3, 4) . '-' . substr($celular, 7, 4);
        }
    }

    public static function valorUnitario($valor)
    {
        $decimalPlace = 2;
        $valor = round((double)$valor, 4);
        $fracao = (double) abs($valor - intval($valor));
        $fracao = round((double)$fracao, 4);

        $fracao = explode('.', $fracao);       
        if (isset($fracao[1])) {
            $fracao = $fracao[1];
            $fracao = substr($fracao, 0, 4);            
            if ( (isset($fracao[3])) && ((int)$fracao[3] > 0)) {
                $decimalPlace = 4;
            } else if ((isset($fracao[2])) &&  ((int)$fracao[2] > 0)) {
                $decimalPlace = 3;
            }
        }

        return 'R$ ' . number_format($valor, $decimalPlace, ',', '.');
    }


    public static function valorTotal($valor)
    {
        $decimalPlace = 2;
        $valor = round((double)$valor, 4);
        $fracao = (double) abs($valor - intval($valor));
        $fracao = round((double)$fracao, 4);

        $fracao = explode('.', $fracao);       
        if (isset($fracao[1])) {
            $fracao = $fracao[1];
            $fracao = substr($fracao, 0, 4);            
            if ( (isset($fracao[3])) && ((int)$fracao[3] > 0)) {
                $decimalPlace = 4;
            } else if ((isset($fracao[2])) &&  ((int)$fracao[2] > 0)) {
                $decimalPlace = 3;
            }
        }

        return 'R$ ' . number_format($valor, $decimalPlace, ',', '.');
    }
}
