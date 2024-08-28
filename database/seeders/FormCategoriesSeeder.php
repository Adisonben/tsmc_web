<?php

namespace Database\Seeders;

use App\Models\Form_category;
use App\Models\Form_type;
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
            [
                'title' => 'การจัดการรถ',
                'type' => [

                ],
            ],
            [
                'title' => 'การจัดการผู้ขับรถ',
                'type' => [
                    "แบบฟอร์มการสอบสัมภาษณ์พนักงานขับรถ",
                ],
            ],
            [
                'title' => 'การจัดการเดินรถ',
                'type' => [

                ],
            ],
            [
                'title' => 'การจัดการบรรทุกและโดยสาร',
                'type' => [

                ],
            ],
            [
                'title' => 'การวิเคราะห์และประเมินผล',
                'type' => [

                ],
            ],
        ];

        foreach ($formCates as $formCate) {
            $form_cate = Form_category::create([
                'name' => $formCate['title'],
            ]);
            if (count($formCate['type'] ?? []) > 0) {
                foreach ($formCate['type'] as $type) {
                    Form_type::create([
                        'name' => $type,
                        'category' => $form_cate->id
                    ]);
                }
            }
        }
    }
}
