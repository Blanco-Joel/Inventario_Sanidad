<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materials = [
            ['name' => 'Venda', 'description' => 'Venda estéril', 'image_path' => 'images/bandage.png'],
            ['name' => 'Guantes', 'description' => 'Guantes de látex', 'image_path' => 'images/gloves.png'],
            ['name' => 'Jeringa', 'description' => 'Jeringa de 5 ml', 'image_path' => 'images/syringe.png'],
            ['name' => 'Catéter', 'description' => 'Catéter intravenoso', 'image_path' => 'images/catheter.png'],
            ['name' => 'Mascarilla', 'description' => 'Mascarilla quirúrgica', 'image_path' => 'images/mask.png'],
            ['name' => 'Termómetro', 'description' => 'Termómetro digital', 'image_path' => 'images/thermometer.png'],
        ];                

        foreach ($materials as $data) {
            Material::create($data);
        }
    }
}
