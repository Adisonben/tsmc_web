<?php

namespace Database\Seeders;

use App\Models\Response_status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $repStats = [
            'ตรวจสอบสำเร็จ',
            'รอตรวจสอบ',
            'ตรวจสอบล้มเหลว',
        ];

        foreach ($repStats as $repStat) {
            Response_status::create([
                'name' => $repStat,
            ]);
        }
    }
}
