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
                'material_id' => 1,
                'storage_type' => 'reserve',
                'cabinet' => 1,
                'shelf' => 1,
                'units' => 120,
                'min_units' => 30,
            ],
            [
                'material_id' => 2, 
                'storage_type' => 'reserve',
                'cabinet' => 1,
                'shelf' => 2,
                'units' => 100,
                'min_units' => 25,
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
