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
                    [
                        "name" => "แบบฟอร์มการตรวจสอบสภาพและความพร้อมของรถ",
                        "code" => "TSM-V-001"
                    ],
                    [
                        "name" => "บันทึกประวัติการบำรุงรักษาและซ่อมรถ",
                        "code" => "TSM-V-002"
                    ],
                    [
                        "name" => "แผนการตรวจสอบและบำรุงรักษารถตามระยะทาง",
                        "code" => "TSM-V-003"
                    ],
                    [
                        "name" => "แผนการบำรุงรักษารถตามกำหนดระยะเวลาการใช้งาน",
                        "code" => "TSM-V-004"
                    ],
                ],
            ],
            [
                'title' => 'การจัดการผู้ขับรถ',
                'type' => [
                    [
                        "name" => "แบบฟอร์มการสอบสัมภาษณ์พนักงานขับรถ",
                        "code" => "TSM-HR-003"
                    ],
                    [
                        "name" => "แบบประเมินความสามารถ",
                        "code" => "TSM-HR-002"
                    ],
                    [
                        "name" => "แบบฟอร์มการตรวจสุขภาพ",
                        "code" => "TSM-HR-001"
                    ],
                    [
                        "name" => "แผนการอบรมของพนักงานขับรถ",
                        "code" => "TSM-HR-006"
                    ]
                ],
            ],
            [
                'title' => 'การจัดการเดินรถ',
                'type' => [
                    [
                        "name" => "บันทึกการปฏิบัติงานประจำวัน",
                        "code" => "TSM-RP-002"
                    ]
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
                    [
                        "name" => "บันทึกหมายเลขโทรศัพท์ฉุกเฉิน",
                        "code" => "TSM-AI-004"
                    ],
                    [
                        "name" => "บันทึกการตรวจสอบและซ่อมบำรุงอุปกรณ์รับมือเหตุการณ์ฉุกเฉิน",
                        "code" => "TSM-AI-005"
                    ]
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
                        'name' => $type["name"],
                        'category' => $form_cate->id,
                        "type_code" => $type['code']
                    ]);
                }
            }
        }
    }
}
