<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Almacenamiento;

class AlmacenamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Material 001 - catéter
        Almacenamiento::create([
            'id_material'   => 'material001',
            'tipo_almacen'  => 'uso',
            'armario'       => 1,
            'balda'         => 1,
            'unidades'      => 50,
            'min_unidades'  => 10,
        ]);

        Almacenamiento::create([
            'id_material'   => 'material001',
            'tipo_almacen'  => 'reserva',
            'armario'       => 2,
            'balda'         => 1,
            'unidades'      => 20,
            'min_unidades'  => 5,
        ]);

        // Material 002 - jeringa
        Almacenamiento::create([
            'id_material'   => 'material002',
            'tipo_almacen'  => 'uso',
            'armario'       => 1,
            'balda'         => 2,
            'unidades'      => 100,
            'min_unidades'  => 15,
        ]);

        // Material 003 - guantes desechables
        Almacenamiento::create([
            'id_material'   => 'material003',
            'tipo_almacen'  => 'uso',
            'armario'       => 2,
            'balda'         => 2,
            'unidades'      => 80,
            'min_unidades'  => 20,
        ]);

        // Material 004 - mascarilla quirúrgica
        Almacenamiento::create([
            'id_material'   => 'material004',
            'tipo_almacen'  => 'uso',
            'armario'       => 3,
            'balda'         => 1,
            'unidades'      => 60,
            'min_unidades'  => 10,
        ]);

        // Material 005 - termómetro digital
        Almacenamiento::create([
            'id_material'   => 'material005',
            'tipo_almacen'  => 'uso',
            'armario'       => 3,
            'balda'         => 2,
            'unidades'      => 30,
            'min_unidades'  => 5,
        ]);
    }
}
