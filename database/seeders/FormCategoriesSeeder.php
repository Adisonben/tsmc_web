<?php

namespace Database\Seeders;

use App\Models\Form_category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formCates = [
            'การจัดการรถ',
            'การจัดการผู้ขับรถ',
            'การจัดการเดินรถ',
            'การจัดการบรรทุกและโดยสาร',
            'การวิเคราะห์และประเมินผล'
        ];

        foreach ($formCates as $formCate) {
            Form_category::create([
                'name' => $formCate,
            ]);
        }
    }
}
