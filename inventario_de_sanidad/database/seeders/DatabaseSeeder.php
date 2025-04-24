<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuarios')->insert([
            ['id_usuario' => 'U001', 'nombre' => 'Ana', 'apellidos' => 'Martínez López', 'fecha_alta' => '2023-01-10', 'fecha_ultima_modificacion' => '2025-04-01', 'email' => 'ana.martinez@email.com', 'clave' => bcrypt('clave1'), 'tipo_usuario' => 'docente'],
            ['id_usuario' => 'U002', 'nombre' => 'Carlos', 'apellidos' => 'Pérez Ruiz', 'fecha_alta' => '2024-03-15', 'fecha_ultima_modificacion' => '2025-04-01', 'email' => 'carlos.perez@email.com', 'clave' => bcrypt('clave2'), 'tipo_usuario' => 'alumno'],
            ['id_usuario' => 'U003', 'nombre' => 'Lucía', 'apellidos' => 'Fernández Soto', 'fecha_alta' => '2023-07-20', 'fecha_ultima_modificacion' => '2025-04-01', 'email' => 'lucia.fernandez@email.com', 'clave' => bcrypt('clave3'), 'tipo_usuario' => 'admin'],
        ]);

        DB::table('materiales')->insert([
            ['id_material' => 'MAT001', 'nombre' => 'Guantes de látex', 'descripcion' => 'Guantes desechables', 'ruta_imagen' => 'img/guantes.jpg'],
            ['id_material' => 'MAT002', 'nombre' => 'Mascarilla quirúrgica', 'descripcion' => 'Protección facial', 'ruta_imagen' => 'img/mascarilla.jpg'],
            // ... (agrega los demás 13 materiales como en el SQL anterior)
        ]);

        DB::table('almacenamiento')->insert([
            ['id_material' => 'MAT001', 'tipo_almacen' => 'reserva', 'armario' => 1, 'balda' => 1, 'unidades' => 120, 'min_unidades' => 30],
            ['id_material' => 'MAT002', 'tipo_almacen' => 'reserva', 'armario' => 1, 'balda' => 2, 'unidades' => 100, 'min_unidades' => 25],
            // ...
        ]);

        DB::table('modificaciones')->insert([
            ['id_usuario' => 'U001', 'id_material' => 'MAT001', 'tipo_almacen' => 'reserva', 'fecha_hora_accion' => now(), 'unidades' => 10],
        ]);

        DB::table('actividades')->insert([
            ['id_actividad' => 'A001', 'id_usuario' => 'U001', 'descripcion' => 'Clase de primeros auxilios', 'fecha_alta' => '2025-04-05'],
        ]);

        DB::table('material_actividad')->insert([
            ['id_actividad' => 'A001', 'id_material' => 'MAT001', 'cantidad' => 10],
        ]);
    }
}
