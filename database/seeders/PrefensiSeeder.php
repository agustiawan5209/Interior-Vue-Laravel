<?php

namespace Database\Seeders;

use App\Models\AlternatifDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrefensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=7; $i < 24; $i++) {
            AlternatifDetail::create(['alternatif_id'=> $i, 'image'=> 'image.jpg']);
        }
    }
}
