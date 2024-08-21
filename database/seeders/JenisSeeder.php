<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis')->insert([
            ['name' => 'Surat Pengantar', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Surat Keterangan Usaha', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
