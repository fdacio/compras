<?php

use App\Uf;
use Illuminate\Database\Seeder;

class UfsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome';
        $json = file_get_contents($url);
        $dados = json_decode($json, true);

        foreach ($dados as $dado) {
            $criar = Uf::where('sigla', $dado['sigla'])->count() == 0;
            if ($criar) {
                $valores['nome'] = $dado['nome'];
                $valores['sigla'] = $dado['sigla'];
                Uf::create($valores);
            }
        }
    }
}
