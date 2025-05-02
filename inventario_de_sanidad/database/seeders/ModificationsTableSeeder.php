<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modification;
use App\Models\User;
use App\Models\Storage;

class ModificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = User::where('role', 'teacher')->first();
        $storage = Storage::inRandomOrder()->first();

        Modification::create([
            'user_id'      => $teacher->user_id,
            'material_id'  => $storage->material_id,
            'storage_type' => $storage->storage_type,
            'timestamp'    => now(),
            'quantity'     => -10,
        ]);
    }
}
