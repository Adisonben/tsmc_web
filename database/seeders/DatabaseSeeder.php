<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PrefixSeeder::class,
            UserSeeder::class,
            PositionSeeder::class,
            CarTypeSeeder::class,
            FormCategoriesSeeder::class,
            OptionSeeder::class,
            PostPermissionSeeder::class,
            ReportStatusSeeder::class,
            PositionPermissionSeeder::class,
        ]);
    }
}
