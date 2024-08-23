<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create([
            'name' => 'ผู้จัดการขนส่ง',
            'created_by' => 0,
            'children' => [
                [
                    'name' => 'ผู้จัดการความปลอดภัยบนถนน',
                    'created_by' => 0,
                ],
                [
                    'name' => 'ผู้จัดการปฏิบัติการขนส่ง',
                    'created_by' => 0,
                    'children' => [
                        [
                            'name' => 'หัวหน้าส่วนควบคุม',
                            'created_by' => 0,
                            'children' => [
                                [
                                    'name' => 'พนักงานขับรถ',
                                    'created_by' => 0,
                                ],
                                [
                                    'name' => 'ผู้ดูแลพนักงานขับรถ',
                                    'created_by' => 0,
                                ],
                            ]
                        ],
                        [
                            'name' => 'หัวหน้าส่วนวางแผนการขนส่ง',
                            'created_by' => 0,
                        ],
                    ]
                ],
                [
                    'name' => 'ผู้จัดการซ่อมบำรุง',
                    'created_by' => 0,
                ],
                [
                    'name' => 'ผู้จัดการธุรการและงานบุคคล',
                    'created_by' => 0,
                    'children' => [
                        [
                            'name' => 'หัวหน้าส่วนงานบุคคล',
                            'created_by' => 0,
                        ],
                    ]
                ],
            ]
        ]);
    }
}
