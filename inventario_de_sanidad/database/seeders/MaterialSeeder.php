<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Material::create([
            'id_material' => 'material001',
            'nombre' => 'catéter',
            'descripcion' => 'Un catéter es, en medicina y enfermería, un dispositivo con forma de tubo estrecho y alargado que se introduce en un tejido o una vena.'
        ]);

        Material::create([
            'id_material' => 'material002',
            'nombre' => 'jeringa',
            'descripcion' => 'Una jeringa se utiliza para inyectar medicamentos o extraer muestras, siendo esencial en diversas intervenciones médicas.'
        ]);

        Material::create([
            'id_material' => 'material003',
            'nombre' => 'guantes desechables',
            'descripcion' => 'Guantes desechables que protegen las manos del paciente y del profesional, minimizando el riesgo de infecciones cruzadas.'
        ]);

        Material::create([
            'id_material' => 'material004',
            'nombre' => 'mascarilla quirúrgica',
            'descripcion' => 'Mascarilla quirúrgica que ayuda a prevenir la transmisión de microorganismos a través del sistema respiratorio.'
        ]);

        Material::create([
            'id_material' => 'material005',
            'nombre' => 'termómetro digital',
            'descripcion' => 'Un termómetro digital utilizado para medir la temperatura corporal, fundamental en el diagnóstico médico.'
        ]);
    }
}
