<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed Users
        DB::table('users')->insert([
            [
                'first_name'     => 'Carlos',
                'last_name'      => 'Pérez Ruiz',
                'email'          => 'carlos.perez@educamadrid.com',
                'hashed_password'=> Hash::make('clave'),
                'first_log'      => false,
                'user_type'      => 'student',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            [
                'first_name'     => 'Marcos',
                'last_name'      => 'Gómez Blanco',
                'email'          => 'marcos.gomez@educamadrid.com',
                'hashed_password'=> Hash::make('clave'),
                'first_log'      => false,
                'user_type'      => 'student',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            [
                'first_name'     => 'Manuel',
                'last_name'      => 'Álvarez Medrano',
                'email'          => 'manuel.alvarez@educamadrid.com',
                'hashed_password'=> Hash::make('clave'),
                'first_log'      => false,
                'user_type'      => 'student',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            [
                'first_name'     => 'Raúl',
                'last_name'      => 'Fernández Díaz',
                'email'          => 'raul.fernandez@educamadrid.com',
                'hashed_password'=> Hash::make('clave'),
                'first_log'      => false,
                'user_type'      => 'student',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            [
                'first_name'     => 'Ariana',
                'last_name'      => 'García Manzano',
                'email'          => 'ariana.garcia@educamadrid.com',
                'hashed_password'=> Hash::make('clave'),
                'first_log'      => false,
                'user_type'      => 'teacher',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            [
                'first_name'     => 'Miriam',
                'last_name'      => 'López Rouco',
                'email'          => 'miriam.lopezrouco@educamadrid.com',
                'hashed_password'=> Hash::make('clave'),
                'first_log'      => false,
                'user_type'      => 'teacher',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            [
                'first_name'     => 'Marta',
                'last_name'      => 'Ramirez Castillo',
                'email'          => 'marta.ramirez@educamadrid.com',
                'hashed_password'=> Hash::make('clave'),
                'first_log'      => false,
                'user_type'      => 'teacher',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            [
                'first_name'     => 'Lucía',
                'last_name'      => 'Fernández Soto',
                'email'          => 'lucia.fernandez@educamadrid.com',
                'hashed_password'=> Hash::make('clave'),
                'first_log'      => false,
                'user_type'      => 'admin',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            [
                'first_name'     => 'Juan',
                'last_name'      => 'Valdés Morilla',
                'email'          => 'juan.valdes@educamadrid.com',
                'hashed_password'=> Hash::make('clave'),
                'first_log'      => false,
                'user_type'      => 'admin',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            
        ]);

        // Seed Materials
        DB::table('materials')->insert([
            ['material_id' => 1, 'name' => 'PEAN', 'description' => 'Pinza de sujeción', 'image_path' => 'materials/pean.jpg'],
            ['material_id' => 2, 'name' => 'Tijeras', 'description' => 'Tijeras quirúrgicas', 'image_path' => 'materials/tijeras.jpg'],
            ['material_id' => 3, 'name' => 'Tijeras Vendaje', 'description' => 'Tijeras para corte de vendajes', 'image_path' => 'materials/tijeras_vendaje.jpg'],
            ['material_id' => 4, 'name' => 'Pinzas de Disección c/ y s/ Dientes', 'description' => 'Pinzas de disección con y sin dientes', 'image_path' => null],
            ['material_id' => 5, 'name' => 'Estelites', 'description' => 'Material utilizado en cirugía dental', 'image_path' => 'materials/estelites.jpg'],
            ['material_id' => 6, 'name' => 'Kocher Rectas/Curvas', 'description' => 'Pinzas Kocher rectas y curvas', 'image_path' => 'materials/kocher_rectas_curvas.jpg'],
            ['material_id' => 7, 'name' => 'Kocher Plástico', 'description' => 'Pinzas Kocher de plástico', 'image_path' => 'materials/kocher_plastico.jpg'],
            ['material_id' => 8, 'name' => 'Sonda Acanalada', 'description' => 'Sonda con canalización', 'image_path' => 'materials/sonda_acanalada.jpg'],
            ['material_id' => 9, 'name' => 'Porta Agujas', 'description' => 'Porta agujas quirúrgicas', 'image_path' => 'materials/porta_agujas.jpg'],
            ['material_id' => 10, 'name' => 'Mangos Bisturí nº4', 'description' => 'Mangos para bisturí número 4', 'image_path' => 'materials/mangos_bisturi_n4.jpg'],
            ['material_id' => 11, 'name' => 'Bisturí Desechable', 'description' => 'Bisturí desechable', 'image_path' => 'materials/bisturi_desechable.jpg'],
            ['material_id' => 12, 'name' => 'Quitagrapas', 'description' => 'Instrumento para retirar grapas', 'image_path' => 'materials/quitagrapas.jpg'],
            ['material_id' => 13, 'name' => 'Bisturí Eléctrico', 'description' => 'Bisturí eléctrico', 'image_path' => 'materials/bisturi_electrico.jpg'],
            ['material_id' => 14, 'name' => 'Tapones Sonda (Caja)', 'description' => 'Tapones para sonda (caja)', 'image_path' => 'materials/tapones_sonda_caja.jpg'],
            ['material_id' => 15, 'name' => 'Tapones Vía (Caja)', 'description' => 'Tapones para vía (caja)', 'image_path' => null],
            ['material_id' => 16, 'name' => 'Llaves 3 Vías c/ y s/ Alargadera', 'description' => 'Llaves de 3 vías con y sin alargadera', 'image_path' => 'materials/llaves_3_vias_c_y_s_alargadera.jpg'],
            ['material_id' => 17, 'name' => 'Cánulas Traqueostomía', 'description' => 'Cánulas para traqueostomía', 'image_path' => 'materials/canulas_traqueostomia.jpg'],
            ['material_id' => 18, 'name' => 'Tracción Adhesiva a Piel', 'description' => 'Sistema de tracción adhesiva para la piel', 'image_path' => 'materials/traccion_adhesiva_a_piel.jpg'],
            ['material_id' => 19, 'name' => 'Bolsas Colostomía Abierta 1 Pieza (Caja)', 'description' => 'Bolsas para colostomía abierta (1 pieza)', 'image_path' => null],
            ['material_id' => 20, 'name' => 'Bolsas Colostomía Cerrada 1 Pieza (Caja)', 'description' => 'Bolsas para colostomía cerrada (1 pieza)', 'image_path' => null],
            ['material_id' => 21, 'name' => 'Bolsas Colostomía Cerrada 2 Piezas (Caja)', 'description' => 'Bolsas para colostomía cerrada (2 piezas)', 'image_path' => null],
            ['material_id' => 22, 'name' => 'Apósitos Hidropolimérico Varias Formas', 'description' => 'Apósitos hidropoliméricos en varias formas', 'image_path' => 'materials/apositos_hidropolimerico_varias_formas.jpg'],
            ['material_id' => 23, 'name' => 'Esparadrapo 2,5 cm Papel', 'description' => 'Esparadrapo de papel (2.5 cm)', 'image_path' => null],
            ['material_id' => 24, 'name' => 'Esparadrapo 2,5 cm Microperforado Transparente', 'description' => 'Esparadrapo microperforado transparente (2.5 cm)', 'image_path' => 'materials/esparadrapo_2_5_cm_microperforado_transparente.jpg'],
            ['material_id' => 25, 'name' => 'Apósitos Transparente Vías (Caja)', 'description' => 'Apósitos transparentes para vías (caja)', 'image_path' => 'materials/apositos_transparente_vias_caja.jpg'],
            ['material_id' => 26, 'name' => 'Mepore Varios Tamaños (Caja)', 'description' => 'Apósitos Mepore de varios tamaños (caja)', 'image_path' => null],
            ['material_id' => 27, 'name' => 'Apósito Aquacel Ag+', 'description' => 'Apósito Aquacel Ag+', 'image_path' => 'materials/aposito_aquacel_ag_plus.jpg'],
            ['material_id' => 28, 'name' => 'Linitul (Caja)', 'description' => 'Linitul (caja)', 'image_path' => 'materials/linitul_caja.jpg'],
            ['material_id' => 29, 'name' => 'Mefix', 'description' => 'Apósitos Mefix', 'image_path' => 'materials/mefix.jpg'],
            ['material_id' => 30, 'name' => 'Baberos Traqueostomía (Caja)', 'description' => 'Baberos para traqueostomía (caja)', 'image_path' => 'materials/baberos_traqueostomia_caja.jpg'],
            ['material_id' => 31, 'name' => 'Depresor Lingual (Caja)', 'description' => 'Depresores linguales (caja)', 'image_path' => 'materials/depresor_lingual_caja.jpg'],
            ['material_id' => 32, 'name' => 'Cepillos Dientes c/ Esponja + Aspirador', 'description' => 'Cepillos de dientes con esponja y aspirador', 'image_path' => 'materials/cepillos_dientes_c_esponja_mas_aspirador.jpg'],
            ['material_id' => 33, 'name' => 'SF Monodosis (Caja)', 'description' => 'Solución fisiológica monodosis (caja)', 'image_path' => 'materials/sf_monodosis_caja.jpg'],
            ['material_id' => 34, 'name' => 'Lubricante', 'description' => 'Lubricante médico', 'image_path' => 'materials/lubricante.jpg'],
        ]);



        // Seed Storages
        DB::table('storages')->insert([
            ['material_id' => 1,  'storage' => 'odontology', 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 1, 'drawer' => null, 'units' => 12, 'min_units' => 4],
            ['material_id' => 1,  'storage' => 'odontology', 'storage_type' => 'use',     'cabinet' => '1',             'shelf' => 1, 'drawer' => 1,    'units' => 7,  'min_units' => 8],
            ['material_id' => 1,  'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 1, 'drawer' => null, 'units' => 12, 'min_units' => 4],
            ['material_id' => 1,  'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '1',             'shelf' => 1, 'drawer' => 1,    'units' => 7,  'min_units' => 8],
            ['material_id' => 2,  'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 1, 'drawer' => null, 'units' => 4,  'min_units' => 6],
            ['material_id' => 2,  'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => 1,               'shelf' => 1, 'drawer' => 2,    'units' => 11, 'min_units' => 6],
            ['material_id' => 3,  'storage' => 'odontology', 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 1, 'drawer' => null, 'units' => 10, 'min_units' => 10],
            ['material_id' => 3,  'storage' => 'odontology', 'storage_type' => 'use',     'cabinet' => 1,               'shelf' => 1, 'drawer' => 1,    'units' => 15, 'min_units' => 13],
            ['material_id' => 4,  'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 1, 'drawer' => null, 'units' => 24, 'min_units' => 20],
            ['material_id' => 4,  'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 2, 'drawer' => 1,    'units' => 12, 'min_units' => 10],
            ['material_id' => 5,  'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 1, 'drawer' => null, 'units' => 44, 'min_units' => 19],
            ['material_id' => 5,  'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 2, 'drawer' => 2,    'units' => 14, 'min_units' => 16],
            ['material_id' => 6,  'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 1, 'drawer' => null, 'units' => 16, 'min_units' => 12],
            ['material_id' => 6,  'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 2, 'drawer' => 3,    'units' => 32, 'min_units' => 32],
            ['material_id' => 7,  'storage' => 'odontology', 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 1, 'drawer' => null, 'units' => 52, 'min_units' => 42],
            ['material_id' => 7,  'storage' => 'odontology', 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 3, 'drawer' => 1,    'units' => 8,  'min_units' => 14],
            ['material_id' => 7,  'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 1, 'drawer' => null, 'units' => 52, 'min_units' => 42],
            ['material_id' => 7,  'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 3, 'drawer' => 1,    'units' => 8,  'min_units' => 14],
            ['material_id' => 8,  'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 2, 'drawer' => null, 'units' => 26, 'min_units' => 23],
            ['material_id' => 8,  'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 3, 'drawer' => 2,    'units' => 27, 'min_units' => 26],
            ['material_id' => 9,  'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 2, 'drawer' => null, 'units' => 12, 'min_units' => 10],
            ['material_id' => 9,  'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 3, 'drawer' => 3,    'units' => 17, 'min_units' => 14],
            ['material_id' => 10, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 2, 'drawer' => null, 'units' => 15, 'min_units' => 11],
            ['material_id' => 10, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 4, 'drawer' => 1,    'units' => 11, 'min_units' => 12],
            ['material_id' => 11, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 2, 'drawer' => null, 'units' => 18, 'min_units' => 13],
            ['material_id' => 11, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 4, 'drawer' => 2,    'units' => 13, 'min_units' => 15],
            ['material_id' => 12, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 3, 'drawer' => null, 'units' => 19, 'min_units' => 17],
            ['material_id' => 12, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 4, 'drawer' => 3,    'units' => 11, 'min_units' => 13],
            ['material_id' => 13, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 3, 'drawer' => null, 'units' => 22, 'min_units' => 13],
            ['material_id' => 13, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 5, 'drawer' => 1,    'units' => 20, 'min_units' => 17],
            ['material_id' => 14, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 3, 'drawer' => null, 'units' => 22, 'min_units' => 21],
            ['material_id' => 14, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 5, 'drawer' => 2,    'units' => 15, 'min_units' => 13],
            ['material_id' => 15, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario gris',  'shelf' => 4, 'drawer' => null, 'units' => 23, 'min_units' => 11],
            ['material_id' => 15, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 5, 'drawer' => 3,    'units' => 24, 'min_units' => 13],
            ['material_id' => 16, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario rojo',  'shelf' => 4, 'drawer' => null, 'units' => 23, 'min_units' => 14],
            ['material_id' => 16, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 6, 'drawer' => 1,    'units' => 19, 'min_units' => 13],
            ['material_id' => 17, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario rojo',  'shelf' => 4, 'drawer' => null, 'units' => 20, 'min_units' => 14],
            ['material_id' => 17, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 6, 'drawer' => 2,    'units' => 21, 'min_units' => 17],
            ['material_id' => 18, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario rojo',  'shelf' => 5, 'drawer' => null, 'units' => 10, 'min_units' => 13],
            ['material_id' => 18, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 6, 'drawer' => 3,    'units' => 12, 'min_units' => 11],
            ['material_id' => 19, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario rojo',  'shelf' => 5, 'drawer' => null, 'units' => 35, 'min_units' => 11],
            ['material_id' => 19, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 7, 'drawer' => 1,    'units' => 32, 'min_units' => 32],
            ['material_id' => 20, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario rojo',  'shelf' => 5, 'drawer' => null, 'units' => 20, 'min_units' => 17],
            ['material_id' => 20, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 7, 'drawer' => 2,    'units' => 23, 'min_units' => 17],
            ['material_id' => 21, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario rojo',  'shelf' => 6, 'drawer' => null, 'units' => 17, 'min_units' => 12],
            ['material_id' => 21, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 7, 'drawer' => 3,    'units' => 33, 'min_units' => 51],
            ['material_id' => 22, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario rojo',  'shelf' => 6, 'drawer' => null, 'units' => 8,  'min_units' => 2 ],
            ['material_id' => 22, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 8, 'drawer' => 1,    'units' => 13, 'min_units' => 12],
            ['material_id' => 23, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario verde', 'shelf' => 6, 'drawer' => null, 'units' => 29, 'min_units' => 45],
            ['material_id' => 23, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 8, 'drawer' => 2,    'units' => 11, 'min_units' => 9 ],
            ['material_id' => 24, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario verde', 'shelf' => 7, 'drawer' => null, 'units' => 15, 'min_units' => 10],
            ['material_id' => 24, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 8, 'drawer' => 3,    'units' => 12, 'min_units' => 11],
            ['material_id' => 25, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario verde', 'shelf' => 7, 'drawer' => null, 'units' => 23, 'min_units' => 24],
            ['material_id' => 25, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 9, 'drawer' => 1,    'units' => 14, 'min_units' => 12],
            ['material_id' => 26, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario verde', 'shelf' => 7, 'drawer' => null, 'units' => 3,  'min_units' => 2],
            ['material_id' => 26, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 9, 'drawer' => 2,    'units' => 9,  'min_units' => 8 ],
            ['material_id' => 27, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario verde', 'shelf' => 8, 'drawer' => null, 'units' => 32, 'min_units' => 26],
            ['material_id' => 27, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 9, 'drawer' => 3,    'units' => 20, 'min_units' => 24],
            ['material_id' => 28, 'storage' => 'CAE'       , 'storage_type' => 'reserve', 'cabinet' => 'armario verde', 'shelf' => 8, 'drawer' => null, 'units' => 20, 'min_units' => 15],
            ['material_id' => 28, 'storage' => 'CAE'       , 'storage_type' => 'use',     'cabinet' => '2',             'shelf' => 10, 'drawer' => 1,   'units' => 20, 'min_units' => 15],

        ]);

        // Seed Modifications
        DB::table('modifications')->insert([
            ['user_id' => 8, 'material_id' => 1, 'storage' => 'CAE', 'storage_type' => 'reserve',  'units' => 10, 'action_datetime' => now()],
            ['user_id' => 6, 'material_id' => 2, 'storage' => 'CAE', 'storage_type' => 'use', 'units' => -5, 'action_datetime' => now()->subDays(5)],
            ['user_id' => 9, 'material_id' => 1, 'storage' => 'CAE', 'storage_type' => 'reserve', 'units' => -3, 'action_datetime' => now()->subDays(10)],
            ['user_id' => 8, 'material_id' => 1, 'storage' => 'CAE', 'storage_type' => 'reserve', 'units' => 15, 'action_datetime' => now()->subDays(3)],
            ['user_id' => 7, 'material_id' => 2, 'storage' => 'CAE', 'storage_type' => 'use',  'units' => -5, 'action_datetime' => now()->subDays(7)],
            ['user_id' => 9, 'material_id' => 1, 'storage' => 'CAE', 'storage_type' => 'reserve', 'units' => -8, 'action_datetime' => now()->subDays(2)],
            ['user_id' => 9, 'material_id' => 1, 'storage' => 'odontology', 'storage_type' => 'reserve',  'units' => 12, 'action_datetime' => now()->subDays(4)],
            ['user_id' => 6, 'material_id' => 3, 'storage' => 'odontology', 'storage_type' => 'use', 'units' => -4, 'action_datetime' => now()->subDays(6)],
            ['user_id' => 9, 'material_id' => 7, 'storage' => 'odontology', 'storage_type' => 'use', 'units' => 9, 'action_datetime' => now()->subDays(1)],
        ]);

        // Seed Activities
        DB::table('activities')->insert([
            ['user_id' => 3, 'title' => 'Taller de Cuidado de Heridas',          'teacher_id' => 5, 'created_at' => Carbon::now()->subDays(1)],
            ['user_id' => 3, 'title' => 'Técnicas de Esterilización',            'teacher_id' => 5, 'created_at' => Carbon::now()->subDays(2)],
            ['user_id' => 3, 'title' => 'Práctica de Suturas',                   'teacher_id' => 5, 'created_at' => Carbon::now()->subDays(3)],
            ['user_id' => 3, 'title' => 'Simulacro de Respuesta a Emergencias', 'teacher_id' => 5, 'created_at' => Carbon::now()->subDays(4)],
            ['user_id' => 3, 'title' => 'Introducción a Instrumentos Quirúrgicos','teacher_id' => 7, 'created_at' => Carbon::now()->subDays(5)],
            ['user_id' => 3, 'title' => 'Sesión de Laboratorio de Anatomía',     'teacher_id' => 7, 'created_at' => Carbon::now()->subDays(6)],
            ['user_id' => 3, 'title' => 'Conceptos Básicos de Manejo de Pacientes','teacher_id' => 7, 'created_at' => Carbon::now()->subDays(7)],
            ['user_id' => 3, 'title' => 'Control de Infecciones',                'teacher_id' => 6, 'created_at' => Carbon::now()->subDays(8)],
            ['user_id' => 3, 'title' => 'Resumen de Farmacología',               'teacher_id' => 6, 'created_at' => Carbon::now()->subDays(9)],
            ['user_id' => 3, 'title' => 'Primeros Auxilios Avanzados',           'teacher_id' => 6, 'created_at' => Carbon::now()->subDays(10)],

            ['user_id' => 4, 'title' => 'Taller de Cuidado de Heridas',          'teacher_id' => 6, 'created_at' => Carbon::now()->subDays(1)],
            ['user_id' => 4, 'title' => 'Técnicas de Esterilización',            'teacher_id' => 6, 'created_at' => Carbon::now()->subDays(2)],
            ['user_id' => 4, 'title' => 'Práctica de Suturas',                   'teacher_id' => 7, 'created_at' => Carbon::now()->subDays(3)],
            ['user_id' => 4, 'title' => 'Simulacro de Respuesta a Emergencias', 'teacher_id' => 7, 'created_at' => Carbon::now()->subDays(4)],
            ['user_id' => 4, 'title' => 'Introducción a Instrumentos Quirúrgicos','teacher_id' => 7, 'created_at' => Carbon::now()->subDays(5)],
            ['user_id' => 4, 'title' => 'Sesión de Laboratorio de Anatomía',     'teacher_id' => 5, 'created_at' => Carbon::now()->subDays(6)],
            ['user_id' => 4, 'title' => 'Conceptos Básicos de Manejo de Pacientes','teacher_id' => 5, 'created_at' => Carbon::now()->subDays(7)],
            ['user_id' => 4, 'title' => 'Control de Infecciones',                'teacher_id' => 5, 'created_at' => Carbon::now()->subDays(8)],
            ['user_id' => 4, 'title' => 'Resumen de Farmacología',               'teacher_id' => 5, 'created_at' => Carbon::now()->subDays(9)],
            ['user_id' => 4, 'title' => 'Primeros Auxilios Avanzados',           'teacher_id' => 5, 'created_at' => Carbon::now()->subDays(10)],
        ]);


        // Seed Material-Activity pivot
        DB::table('material_activity')->insert([
            ['activity_id' => 2, 'material_id' => 2,  'units' => 5],
            ['activity_id' => 2, 'material_id' => 5,  'units' => 5],
            ['activity_id' => 2, 'material_id' => 6,  'units' => 15],
            ['activity_id' => 3, 'material_id' => 3,  'units' => 7],
            ['activity_id' => 3, 'material_id' => 2,  'units' => 1],
            ['activity_id' => 4, 'material_id' => 1,  'units' => 10],
            ['activity_id' => 5, 'material_id' => 4,  'units' => 8],
            ['activity_id' => 6, 'material_id' => 4,  'units' => 1],
            ['activity_id' => 6, 'material_id' => 5,  'units' => 6],
            ['activity_id' => 7, 'material_id' => 6,  'units' => 4],
            ['activity_id' => 8, 'material_id' => 7,  'units' => 9],
            ['activity_id' => 9, 'material_id' => 8,  'units' => 3],
            ['activity_id' => 9, 'material_id' => 10, 'units' => 1],
            ['activity_id' => 9, 'material_id' => 1,  'units' => 2],
            ['activity_id' => 9, 'material_id' => 3,  'units' => 1],
            ['activity_id' => 10,'material_id' => 9,  'units' => 2],
            ['activity_id' => 11,'material_id' => 10, 'units' => 5],
            ['activity_id' => 12,'material_id' => 11, 'units' => 7],
            ['activity_id' => 13,'material_id' => 12, 'units' => 6],
            ['activity_id' => 14,'material_id' => 13, 'units' => 8],
            ['activity_id' => 15,'material_id' => 14, 'units' => 4],
            ['activity_id' => 16,'material_id' => 15, 'units' => 3],
            ['activity_id' => 17,'material_id' => 16, 'units' => 7],
            ['activity_id' => 18,'material_id' => 17, 'units' => 5],
            ['activity_id' => 19,'material_id' => 18, 'units' => 6],
        ]);
    }
}
