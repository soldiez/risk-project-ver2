<?php

namespace Database\Seeders;

use App\Models\Unit\JobPosition;
use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        JobPosition::factory()
            ->count(20)
            ->create();
    }
}
