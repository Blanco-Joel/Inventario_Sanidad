<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Storage;
use App\Models\Material;

class StorageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Material::all()->each(function($material) {
            Storage::create([
                'material_id'  => $material->material_id,
                'storage_type' => 'use',
                'cabinet'      => rand(1, 5),
                'shelf'        => rand(1, 10),
                'quantity'     => 100,
                'min_quantity' => 10,
            ]);

            Storage::create([
                'material_id'  => $material->material_id,
                'storage_type' => 'reserve',
                'cabinet'      => rand(1, 5),
                'shelf'        => rand(1, 10),
                'quantity'     => 50,
                'min_quantity' => 5,
            ]);
        });
    }
}
