<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'id_usuario' => 'user001',
            'nombre' => 'Miriam',
            'apellidos' => 'López Rouco',
            'fecha_alta' => now(),
            'tipo_usuario' => 'docente'
        ]);

        Usuario::create([
            'id_usuario' => 'user002',
            'nombre' => 'William Elías',
            'apellidos' => 'Díaz Santana',
            'fecha_alta' => now(),
            'tipo_usuario' => 'alumno'
        ]);

        Usuario::create([
            'id_usuario' => 'user003',
            'nombre' => 'Pedro',
            'apellidos' => 'García Gómez',
            'fecha_alta' => now(),
            'tipo_usuario' => 'docente'
        ]);
    }
}
