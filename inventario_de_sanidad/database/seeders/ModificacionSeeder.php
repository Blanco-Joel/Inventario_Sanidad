<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modificacion;
use Carbon\Carbon;

class ModificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Modificación para material001 (catéter) - se utiliza 'uso'
        Modificacion::create([
            'id_usuario'    => 'user001',
            'id_material'   => 'material001',
            'fecha_accion'  => Carbon::now()->subDays(2),
            'accion'        => 'sumar',
            'unidades'      => 15,
            'tipo_almacen'  => 'uso',
        ]);

        // Modificación para material002 (jeringa) - se ajusta a 'uso'
        Modificacion::create([
            'id_usuario'    => 'user001',
            'id_material'   => 'material002',
            'fecha_accion'  => Carbon::now()->subDays(1)->subHours(4),
            'accion'        => 'restar',
            'unidades'      => 7,
            'tipo_almacen'  => 'uso', // Cambiado de 'reserva' a 'uso'
        ]);

        // Modificación para material003 (guantes desechables)
        Modificacion::create([
            'id_usuario'    => 'user003',
            'id_material'   => 'material003',
            'fecha_accion'  => Carbon::now()->subHours(3),
            'accion'        => 'sumar',
            'unidades'      => 20,
            'tipo_almacen'  => 'uso',
        ]);

        // Modificación para material004 (mascarilla quirúrgica)
        Modificacion::create([
            'id_usuario'    => 'user003',
            'id_material'   => 'material004',
            'fecha_accion'  => Carbon::now(),
            'accion'        => 'restar',
            'unidades'      => 5,
            'tipo_almacen'  => 'uso',
        ]);

        // Opcional: Agregar modificación para material005 (termómetro digital)
        Modificacion::create([
            'id_usuario'    => 'user002',
            'id_material'   => 'material005',
            'fecha_accion'  => Carbon::now()->subHours(2),
            'accion'        => 'sumar',
            'unidades'      => 10,
            'tipo_almacen'  => 'uso',
        ]);
    }
}
