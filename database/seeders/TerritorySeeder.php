<?php

namespace Database\Seeders;

use App\Models\Unit\Territory;
use Illuminate\Database\Seeder;

class TerritorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Territory::factory()
        ->count(20)
        ->create();
    }
}
