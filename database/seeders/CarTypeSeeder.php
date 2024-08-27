<?php

namespace Database\Seeders;

use App\Models\Car_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carTypes = [
            'Truck',
            'Bus',
        ];

        foreach ($carTypes as $carType) {
            Car_type::create([
                'name' => $carType,
                'created_by' => 0
            ]);
        }
    }
}
