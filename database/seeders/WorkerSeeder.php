<?php

namespace Database\Seeders;

use App\Models\Unit\Worker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        DB::table('workers')-

        Worker::factory()
            ->count(20)
            ->create();
    }
}
