<?php

namespace Database\Seeders;

use App\Models\Unit\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Position::factory()
            ->count(20)
            ->create();
    }
}
