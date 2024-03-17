<?php

use App\TipoUsuario;
use Illuminate\Database\Seeder;

class CreateTiposUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $dados = [
            ['id' => 1, 'nome' => 'Manutenção'],
            ['id' => 2, 'nome' => 'Administrador'],
            ['id' => 3, 'nome' => 'Operador']
        ];

        foreach ($dados as $dado) {
            $create = TipoUsuario::where('id', $dado['id'])->get()->count() == 0;
            if ($create) {
                TipoUsuario::create($dado);
            }
        }
    }
}
