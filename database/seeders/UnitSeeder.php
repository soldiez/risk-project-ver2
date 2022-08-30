<?php

namespace Database\Seeders;

use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::factory()
            ->create();
    }
}
