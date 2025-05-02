<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            SubjectsTableSeeder::class,
            MaterialsTableSeeder::class,
            StorageTableSeeder::class,
            ActivitiesTableSeeder::class,
            ActivityMaterialTableSeeder::class,
            ModificationsTableSeeder::class,
        ]);
    }
}
