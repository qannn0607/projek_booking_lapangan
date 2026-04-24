<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Field::create(['name' => 'Lapangan Futsal A', 'price_per_hour' => 150000]);
    \App\Models\Field::create(['name' => 'Lapangan Futsal B', 'price_per_hour' => 125000]);
}
}
