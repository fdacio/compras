<?php

use App\TipoVeiculo;
use Illuminate\Database\Seeder;

class TiposVeiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            ['id' => 1, 'nome' => 'Caminhão'],
            ['id' => 2, 'nome' => 'Caminhonete'],
            ['id' => 3, 'nome' => 'Veículo Leve'],
            ['id' => 4, 'nome' => 'Utilitário'],
            ['id' => 5, 'nome' => 'Motocicleta'],
            ['id' => 6, 'nome' => 'Reboque'],
            ['id' => 7, 'nome' => 'Máquina'],
        ];

        foreach ($dados as $dado) {
            $create = TipoVeiculo::where('id', $dado['id'])->get()->count() == 0;
            if ($create) {
                TipoVeiculo::create($dado);
            }
        }
    }
}
