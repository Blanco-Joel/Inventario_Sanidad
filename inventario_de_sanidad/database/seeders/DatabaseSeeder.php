<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Insert Users
        DB::table('users')->insert([
            [
                'first_name' => 'Ana',
                'last_name' => 'Martínez López',
                'created_at' => '2023-01-10 00:00:00',
                'last_modified' => '2025-04-01',
                'email' => 'ana.martinez@email.com',
                'password' => 'clave1',
                'hashed_password' => Hash::make('clave1'),
                'firstLog' => false,
                'user_type' => 'teacher',
            ],
            [
                'first_name' => 'Carlos',
                'last_name' => 'Pérez Ruiz',
                'created_at' => '2024-03-15 00:00:00',
                'last_modified' => '2025-04-01',
                'email' => 'carlos.perez@email.com',
                'password' => 'clave2',
                'hashed_password' => Hash::make('clave2'),
                'firstLog' => false,
                'user_type' => 'student',
            ],
            [
                'first_name' => 'Lucía',
                'last_name' => 'Fernández Soto',
                'created_at' => '2023-07-20 00:00:00',
                'last_modified' => '2025-04-01',
                'email' => 'lucia.fernandez@email.com',
                'password' => 'clave3',
                'hashed_password' => Hash::make('clave3'),
                'firstLog' => false,
                'user_type' => 'admin',
            ],
        ]);

        // Insert Materials
        DB::table('materials')->insert([
            [
                'name' => 'Latex Gloves',
                'description' => 'Disposable gloves',
                'image_path' => 'img/gloves.jpg',
            ],
            [
                'name' => 'Surgical Mask',
                'description' => 'Face protection',
                'image_path' => 'img/mask.jpg',
            ],
        ]);

        // Insert Storage
        DB::table('storage')->insert([
            [
                'material_id'  => 1,
                'storage_type' => 'reserve',
                'cabinet'      => 1,
                'shelf'        => 1,
                'units'        => 120,
                'min_units'    => 30,
            ],
            [
                'material_id'  => 1,
                'storage_type' => 'use',
                'cabinet'      => 2,
                'shelf'        => 1,
                'units'        => 50,
                'min_units'    => 10,
            ],
            [
                'material_id'  => 2,
                'storage_type' => 'reserve',
                'cabinet'      => 1,
                'shelf'        => 2,
                'units'        => 100,
                'min_units'    => 25,
            ],
            [
                'material_id'  => 2,
                'storage_type' => 'use',
                'cabinet'      => 2,
                'shelf'        => 2,
                'units'        => 40,
                'min_units'    => 10,
            ],
        ]);

        // Insert Modifications
        DB::table('modifications')->insert([
            [
                'user_id' => 1, // Ana (primer usuario)
                'material_id' => 1, // Latex Gloves
                'storage_type' => 'reserve',
                'action_datetime' => now(),
                'units' => 10,
            ],
            [
                'user_id' => 2, // Usuario 2
                'material_id' => 2, // Otro material
                'storage_type' => 'use',
                'action_datetime' => now()->subDays(5), // Fecha hace 5 días
                'units' => -5,
            ],
            [
                'user_id' => 3, // Usuario 3
                'material_id' => 1, // Latex Gloves
                'storage_type' => 'use',
                'action_datetime' => now()->subDays(10), // Fecha hace 10 días
                'units' => -3,
            ],
            [
                'user_id' => 1, // Ana
                'material_id' => 1, // Latex Gloves
                'storage_type' => 'reserve',
                'action_datetime' => now()->addDays(3), // Fecha en 3 días
                'units' => 15,
            ],
            [
                'user_id' => 2, // Usuario 2
                'material_id' => 2, // Otro material
                'storage_type' => 'reserve',
                'action_datetime' => now()->addDays(7), // Fecha en 7 días
                'units' => 20,
            ],
            [
                'user_id' => 3, // Usuario 3
                'material_id' => 1, // Latex Gloves
                'storage_type' => 'use',
                'action_datetime' => now()->subDays(2), // Fecha hace 2 días
                'units' => -8,
            ],
        ]);

        // Insert Activities
        DB::table('activities')->insert([
            [
                'user_id' => 1, // Ana
                'description' => 'First aid class',
                'created_at' => '2025-04-05 00:00:00',
            ],
        ]);

        // Insert Material-Activity
        DB::table('material_activity')->insert([
            [
                'activity_id' => 1, // First activity
                'material_id' => 1, // Latex Gloves
                'quantity' => 10,
            ],
        ]);
    }
}
