<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopikSeeder extends Seeder
{
    public function run()
    {
        $topiks = [
            ['topik' => 'Kesehatan'],
            ['topik' => 'Pendidikan'],
            ['topik' => 'Ekonomi'],
            ['topik' => 'Teknologi'],
            ['topik' => 'Lain-lain']
        ];

        DB::table('topiks')->insert($topiks);
    }
}