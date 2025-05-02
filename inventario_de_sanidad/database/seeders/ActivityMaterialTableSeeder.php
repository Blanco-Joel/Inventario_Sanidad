<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\Material;

class ActivityMaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materials = Material::all();

        Activity::all()->each(function($activity) use ($materials) {
            $materials->random(2)->each(function($material) use ($activity) {
                $activity->materials()->attach($material->material_id, [
                    'quantity' => rand(1, 5),
                ]);
            });
        });
    }
}
