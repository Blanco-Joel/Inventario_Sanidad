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
                'first_name'     => 'Ana',
                'last_name'      => 'Martínez López',
                'email'          => 'ana.martinez@example.com',
                'password'       => 'clave1',
                'hashed_password'=> Hash::make('clave1'),
                'first_log'      => false,
                'user_type'      => 'teacher',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            [
                'first_name'     => 'Carlos',
                'last_name'      => 'Pérez Ruiz',
                'email'          => 'carlos.perez@example.com',
                'password'       => 'clave2',
                'hashed_password'=> Hash::make('clave2'),
                'first_log'      => false,
                'user_type'      => 'student',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            [
                'first_name'     => 'Lucía',
                'last_name'      => 'Fernández Soto',
                'email'          => 'lucia.fernandez@example.com',
                'password'       => 'clave3',
                'hashed_password'=> Hash::make('clave3'),
                'first_log'      => false,
                'user_type'      => 'admin',
                'created_at'     => Carbon::now('Europe/Madrid')
            ],
            
        ]);
        $roles = ['teacher', 'student', 'admin'];
        for ($i = 4; $i <= 100; $i++) {
            $nombre = "Usuario$i";
            $apellido = "Apellido$i";
            $email = "usuario$i@example.com";
            $clave = "clave$i";
            $rol = $roles[($i - 1) % count($roles)];
    
            DB::table('users')->insert([
                'first_name'     => $nombre,
                'last_name'      => $apellido,
                'email'          => $email,
                'password'       => $clave,
                'hashed_password'=> Hash::make($clave),
                'first_log'      => false,
                'user_type'      => $rol,
                'created_at'     => Carbon::now('Europe/Madrid')
            ]);
        }
        // Seed Materials
        DB::table('materials')->insert([
            [
                'material_id' => 1,
                'name'        => 'PEAN',
                'description' => 'Pinza de sujeción',
                'image_path'  => null,
            ],
            [
                'material_id' => 2,
                'name'        => 'Tijeras',
                'description' => 'Tijeras quirúrgicas',
                'image_path'  => null,
            ],
            [
                'material_id' => 3,
                'name'        => 'Tijeras Vendaje',
                'description' => 'Tijeras para corte de vendajes',
                'image_path'  => null,
            ],
            [
                'material_id' => 4,
                'name'        => 'Pinzas de Disección c/ y s/ Dientes',
                'description' => 'Pinzas de disección con y sin dientes',
                'image_path'  => null,
            ],
            [
                'material_id' => 5,
                'name'        => 'Estelites',
                'description' => 'Material utilizado en cirugía dental',
                'image_path'  => null,
            ],
            [
                'material_id' => 6,
                'name'        => 'Kocher Rectas/Curvas',
                'description' => 'Pinzas Kocher rectas y curvas',
                'image_path'  => null,
            ],
            [
                'material_id' => 7,
                'name'        => 'Kocher Plástico',
                'description' => 'Pinzas Kocher de plástico',
                'image_path'  => null,
            ],
            [
                'material_id' => 8,
                'name'        => 'Sonda Acanalada',
                'description' => 'Sonda con canalización',
                'image_path'  => null,
            ],
            [
                'material_id' => 9,
                'name'        => 'Porta Agujas',
                'description' => 'Porta agujas quirúrgicas',
                'image_path'  => null,
            ],
            [
                'material_id' => 10,
                'name'        => 'Mangos Bisturí nº4',
                'description' => 'Mangos para bisturí número 4',
                'image_path'  => null,
            ],
            [
                'material_id' => 11,
                'name'        => 'Bisturí Desechable',
                'description' => 'Bisturí desechable',
                'image_path'  => null,
            ],
            [
                'material_id' => 12,
                'name'        => 'Quitagrapas',
                'description' => 'Instrumento para retirar grapas',
                'image_path'  => null,
            ],
            [
                'material_id' => 13,
                'name'        => 'Bisturí Eléctrico',
                'description' => 'Bisturí eléctrico',
                'image_path'  => null,
            ],
            [
                'material_id' => 14,
                'name'        => 'Tapones Sonda (Caja)',
                'description' => 'Tapones para sonda (caja)',
                'image_path'  => null,
            ],
            [
                'material_id' => 15,
                'name'        => 'Tapones Vía (Caja)',
                'description' => 'Tapones para vía (caja)',
                'image_path'  => null,
            ],
            [
                'material_id' => 16,
                'name'        => 'Llaves 3 Vías c/ y s/ Alargadera',
                'description' => 'Llaves de 3 vías con y sin alargadera',
                'image_path'  => null,
            ],
            [
                'material_id' => 17,
                'name'        => 'Cánulas Traqueostomía',
                'description' => 'Cánulas para traqueostomía',
                'image_path'  => null,
            ],
            [
                'material_id' => 18,
                'name'        => 'Tracción Adhesiva a Piel',
                'description' => 'Sistema de tracción adhesiva para la piel',
                'image_path'  => null,
            ],
            [
                'material_id' => 19,
                'name'        => 'Bolsas Colostomía Abierta 1 Pieza (Caja)',
                'description' => 'Bolsas para colostomía abierta (1 pieza)',
                'image_path'  => null,
            ],
            [
                'material_id' => 20,
                'name'        => 'Bolsas Colostomía Cerrada 1 Pieza (Caja)',
                'description' => 'Bolsas para colostomía cerrada (1 pieza)',
                'image_path'  => null,
            ],
            [
                'material_id' => 21,
                'name'        => 'Bolsas Colostomía Cerrada 2 Piezas (Caja)',
                'description' => 'Bolsas para colostomía cerrada (2 piezas)',
                'image_path'  => null,
            ],
            [
                'material_id' => 22,
                'name'        => 'Apósitos Hidropolimérico Varias Formas',
                'description' => 'Apósitos hidropoliméricos en varias formas',
                'image_path'  => null,
            ],
            [
                'material_id' => 23,
                'name'        => 'Esparadrapo 2,5 cm Papel',
                'description' => 'Esparadrapo de papel (2.5 cm)',
                'image_path'  => null,
            ],
            [
                'material_id' => 24,
                'name'        => 'Esparadrapo 2,5 cm Microperforado Transparente',
                'description' => 'Esparadrapo microperforado transparente (2.5 cm)',
                'image_path'  => null,
            ],
            [
                'material_id' => 25,
                'name'        => 'Apósitos Transparente Vías (Caja)',
                'description' => 'Apósitos transparentes para vías (caja)',
                'image_path'  => null,
            ],
            [
                'material_id' => 26,
                'name'        => 'Mepore Varios Tamaños (Caja)',
                'description' => 'Apósitos Mepore de varios tamaños (caja)',
                'image_path'  => null,
            ],
            [
                'material_id' => 27,
                'name'        => 'Apósito Aquacel Ag+',
                'description' => 'Apósito Aquacel Ag+',
                'image_path'  => null,
            ],
            [
                'material_id' => 28,
                'name'        => 'Linitul (Caja)',
                'description' => 'Linitul (caja)',
                'image_path'  => null,
            ],
            [
                'material_id' => 29,
                'name'        => 'Mefix',
                'description' => 'Apósitos Mefix',
                'image_path'  => null,
            ],
            [
                'material_id' => 30,
                'name'        => 'Baberos Traqueostomía (Caja)',
                'description' => 'Baberos para traqueostomía (caja)',
                'image_path'  => null,
            ],
            [
                'material_id' => 31,
                'name'        => 'Depresor Lingual (Caja)',
                'description' => 'Depresores linguales (caja)',
                'image_path'  => null,
            ],
            [
                'material_id' => 32,
                'name'        => 'Cepillos Dientes c/ Esponja + Aspirador',
                'description' => 'Cepillos de dientes con esponja y aspirador',
                'image_path'  => null,
            ],
            [
                'material_id' => 33,
                'name'        => 'SF Monodosis (Caja)',
                'description' => 'Solución fisiológica monodosis (caja)',
                'image_path'  => null,
            ],
            [
                'material_id' => 34,
                'name'        => 'Lubricante',
                'description' => 'Lubricante médico',
                'image_path'  => null,
            ],
        ]);

        // Seed Storages
        DB::table('storages')->insert([
            [
                'material_id'  => (3-2),
                'storage'      => 'CAE',
                'storage_type' => 'use',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 7,
                'min_units'    => 8,
            ],
            [
                'material_id'  => (3-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 7,
                'min_units'    => 8,
            ],
            [
                'material_id'  => (4-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 11,
                'min_units'    => 6,
            ],
            [
                'material_id'  => (5-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 2,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (6-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 15,
                'min_units'    => 8,
            ],
            [
                'material_id'  => (7-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 4,
                'min_units'    => 2,
            ],
            [
                'material_id'  => (8-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 15,
                'min_units'    => 8,
            ],
            [
                'material_id'  => (9-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 30,
                'min_units'    => 15,
            ],
            [
                'material_id'  => (10-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 6,
                'min_units'    => 3,
            ],
            [
                'material_id'  => (11-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 3,
                'min_units'    => 2,
            ],
            [
                'material_id'  => (12-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 9,
                'min_units'    => 5,
            ],
            [
                'material_id'  => (13-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 3,
                'min_units'    => 2,
            ],
            [
                'material_id'  => (14-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 1,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (15-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 2,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (16-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 1,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (17-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 15,
                'min_units'    => 8,
            ],
            [
                'material_id'  => (18-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 12,
                'min_units'    => 6,
            ],
            [
                'material_id'  => (19-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 1,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (20-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 1,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (21-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 1,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (22-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 3,
                'min_units'    => 2,
            ],
            [
                'material_id'  => (23-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 1,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (24-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 1,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (25-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 1,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (26-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 3,
                'min_units'    => 2,
            ],
            [
                'material_id'  => (27-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 1,
                'min_units'    => 1,
            ],
            [
                'material_id'  => (28-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 15,
                'min_units'    => 8,
            ],
            [
                'material_id'  => (29-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 3,
                'min_units'    => 2,
            ],
            [
                'material_id'  => (30-2),
                'storage'      => 'CAE',
                'storage_type' => 'reserve',
                'cabinet'      => 'armario gris',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 25,
                'min_units'    => 13,
            ]
        ]);

        // Seed Modifications
        DB::table('modifications')->insert([
            [
                'user_id' => 1,
                'material_id' => 1,
                'storage_type' => 'reserve',
                'action_datetime' => now(),
                'units' => 10,
            ],
            [
                'user_id' => 2,
                'material_id' => 2,
                'storage_type' => 'reserve',
                'action_datetime' => now()->subDays(5),
                'units' => -5,
            ],
            [
                'user_id' => 3,
                'material_id' => 1,
                'storage_type' => 'reserve',
                'action_datetime' => now()->subDays(10),
                'units' => -3,
            ],
            [
                'user_id' => 1,
                'material_id' => 1,
                'storage_type' => 'reserve',
                'action_datetime' => now()->subDays(3),
                'units' => 15,
            ],
            [
                'user_id' => 2,
                'material_id' => 2,
                'storage_type' => 'reserve',
                'action_datetime' => now()->subDays(7),
                'units' => 20,
            ],
            [
                'user_id' => 3,
                'material_id' => 1,
                'storage_type' => 'reserve',
                'action_datetime' => now()->subDays(2),
                'units' => -8,
            ],
        ]);

        // Seed Activities
        DB::table('activities')->insert([
            [
                'user_id'      => 2,
                'title'  => 'First aid practice',
                'created_at'   => Carbon::now()->subDays(3),
            ],
        ]);

        // Seed Material-Activity pivot
        DB::table('material_activity')->insert([
            [
                'activity_id' => 1,
                'material_id' => 1,
                'units'       => 10,
            ],
        ]);
    }
}
