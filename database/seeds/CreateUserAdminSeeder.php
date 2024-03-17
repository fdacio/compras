<?php

use App\User;
use Illuminate\Database\Seeder;

class CreateUserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'name' => 'Administrador',
            'email' => 'admin@daciosoftware.com.br',
            'id_tipo' => 1,
            'password' => bcrypt('123321')
        ];

        $create = User::where('email', $dados['email'])->get()->count() == 0;

        if ($create) {
            User::create($dados);
        }
    }
}
