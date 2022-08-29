<?php

namespace Database\Seeders;

use App\Models\Unit\Worker;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Worker::factory()
            ->count(20)
            ->create();
    }
}
