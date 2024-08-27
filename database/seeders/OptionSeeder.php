<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Option_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $optTypes = [
            [
                'title' => 'ใช่/ไม่ใช่',
                'option' => [
                    [
                        'text' => 'ใช่',
                        'score' => 1
                    ],
                    [
                        'text' => 'ไม่ใช่',
                        'score' => 0
                    ]
                ],
            ],
            [
                'title' => 'ผ่าน/ไม่ผ่าน',
                'option' => [
                    [
                        'text' => 'ผ่าน',
                        'score' => 1
                    ],
                    [
                        'text' => 'ไม่ผ่าน',
                        'score' => 0
                    ]
                ],
            ],
        ];

        foreach ($optTypes as $optType) {
            $optTypeStored = Option_type::create([
                'name' => $optType['title'],
            ]);

            if (count($optType['option'] ?? []) > 0) {
                foreach ($optType['option'] as $option) {
                    Option::create([
                        'opt_text' => $option['text'],
                        'score' => $option['score'],
                        'opt_type' => $optTypeStored->id
                    ]);
                }
            }
        }
    }
}
