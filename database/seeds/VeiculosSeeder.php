<?php

use App\TipoVeiculo;
use App\Veiculo;
use Illuminate\Database\Seeder;

class VeiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $handle = fopen("database/seeds/dados/cad-veiculos.csv", "r");
        $row = 0;
        $itens = [];
        while ($line = fgetcsv($handle, 1000, ";")) {
            if ($row++ == 0) {
                continue;
            }

            $itens[] = [
                'id' => $line[0],
                'tipo' => $line[1],
                'placa' => $line[2],
                'marca' => $line[3],
                'modelo' => $line[4],
                'ano_fabricacao' => $line[5],
                'ano_modelo' => $line[6],
                'frota' => $line[7],
                'empresa' => $line[8],
                'cidade' => $line[9],
                'lotacao' => $line[10],
                'valor_locacao' => $line[11]
            ];
        }
        fclose($handle);

        foreach($itens as $item) {

            $tipo = strtolower($item['tipo']);
            $tipoVeiculo = TipoVeiculo::whereRaw('LOWER(nome) like ?', $tipo)->first();
            
            print_r("ID_VEICULO: " . $item['id'] . "\n");
            print_r("ID_TIPO: " . $tipoVeiculo->id . "\n");
            print_r("NOME: " . $tipoVeiculo->nome . "\n");
            print_r("----------------------- \n");

            
            $placa = $item['placa'];
            $marca = $item['marca'];
            $modelo = $item['modelo'];
            $cor = 'NÃO INFORMADA';
            $renavan = 'NÃO INFORMADO';
            $ano = $item['ano_fabricacao'];
            $idEmpresa = 1000;
            $idCentroCusto = 1000;
            $idFrota = 1000;
            $uf = 'CE';

            $dados = [
                'id_empresa' => $idEmpresa,
                'id_frota' => $idFrota,
                'id_centro_custo' => $idCentroCusto,
                'id_tipo_veiculo' => $tipoVeiculo->id,
                'placa' => $placa,
                'marca' => $marca,
                'modelo' => $modelo,
                'renavan' => $renavan,
                'cor' => $cor,
                'ano' => $ano,
                'uf' => $uf
            ];

            Veiculo::create($dados);
        }
    }
}
