<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsuarioSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(AlmacenamientoSeeder::class);
        $this->call(ModificacionSeeder::class);
    }
}
