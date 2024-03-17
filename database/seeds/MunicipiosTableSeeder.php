<?php

use App\Municipio;
use App\Uf;
use Illuminate\Database\Seeder;

class MunicipiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ufs = Uf::orderBy('id', 'asc')->get();
        foreach ($ufs as $uf) {
            $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf->sigla}/municipios";
            $json = file_get_contents($url);
            $dados = json_decode($json, true);
            foreach ($dados as $dado) {
                $valores['nome'] =  $dado['nome'];
                $valores['id_uf'] = $uf->id;
                $valores['codigo_ibge'] = $dado['id'];
                $criar = Municipio::where('codigo_ibge', $dado['id'])->count() == 0;
                if ($criar) {
                    Municipio::create($valores);
                }
            }
        }
    }
}
