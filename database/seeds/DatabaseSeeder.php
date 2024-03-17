<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateTiposUsuariosSeeder::class);
        $this->call(CreateUserAdminSeeder::class);
        $this->call(UfsTableSeeder::class);
        $this->call(MunicipiosTableSeeder::class);
    }
}
