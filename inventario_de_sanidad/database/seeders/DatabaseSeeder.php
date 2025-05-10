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
                'hashed_password'=> Hash::make('clave1'),
                'first_log'      => false,
                'user_type'      => 'teacher',
                'created_at'     => Carbon::create(2023, 1, 10, 0, 0, 0),
                'updated_at'     => Carbon::create(2025, 4, 1, 0, 0, 0),
            ],
            [
                'first_name'     => 'Carlos',
                'last_name'      => 'Pérez Ruiz',
                'email'          => 'carlos.perez@example.com',
                'hashed_password'=> Hash::make('clave2'),
                'first_log'      => false,
                'user_type'      => 'student',
                'created_at'     => Carbon::create(2024, 3, 15, 0, 0, 0),
                'updated_at'     => Carbon::create(2025, 4, 1, 0, 0, 0),
            ],
            [
                'first_name'     => 'Lucía',
                'last_name'      => 'Fernández Soto',
                'email'          => 'lucia.fernandez@example.com',
                'hashed_password'=> Hash::make('clave3'),
                'first_log'      => false,
                'user_type'      => 'admin',
                'created_at'     => Carbon::create(2023, 7, 20, 0, 0, 0),
                'updated_at'     => Carbon::create(2025, 4, 1, 0, 0, 0),
            ],
        ]);

        // Seed Materials
        DB::table('materials')->insert([
            [
                'name'        => 'Latex Gloves',
                'description' => 'Disposable gloves',
                'image_path'  => 'img/gloves.jpg',
            ],
            [
                'name'        => 'Surgical Mask',
                'description' => 'Face protection',
                'image_path'  => 'img/mask.jpg',
            ],
        ]);

        // Seed Storages
        DB::table('storages')->insert([
            [
                'material_id'  => 1,
                'storage_type' => 'reserve',
                'cabinet'      => '1',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 120,
                'min_units'    => 30,
            ],
            [
                'material_id'  => 1,
                'storage_type' => 'use',
                'cabinet'      => '1',
                'shelf'        => 1,
                'drawer'       => null,
                'units'        => 0,
                'min_units'    => 0,
            ],
            [
                'material_id'  => 2,
                'storage_type' => 'reserve',
                'cabinet'      => '2',
                'shelf'        => 2,
                'drawer'       => null,
                'units'        => 100,
                'min_units'    => 25,
            ],
            [
                'material_id'  => 2,
                'storage_type' => 'use',
                'cabinet'      => '2',
                'shelf'        => 2,
                'drawer'       => null,
                'units'        => 0,
                'min_units'    => 0,
            ],
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
                'storage_type' => 'use',
                'action_datetime' => now()->subDays(5),
                'units' => -5,
            ],
            [
                'user_id' => 3,
                'material_id' => 1,
                'storage_type' => 'use',
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
                'storage_type' => 'use',
                'action_datetime' => now()->subDays(2),
                'units' => -8,
            ],
        ]);

        // Seed Activities
        DB::table('activities')->insert([
            [
                'user_id'      => 2,
                'description'  => 'First aid practice',
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
