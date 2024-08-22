<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prefixs = [
            'นาย',
            'นาง',
            'นางสาว',
        ];

        foreach ($prefixs as $prefix) {
            DB::table('prefixes')->insert([
                'name' => $prefix,
                'created_by' => 0
            ]);
        }
    }
}
