<?php

namespace Database\Seeders;

use App\Models\Unit\Department;
use App\Models\Unit\Position;
use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OneCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $unit = Unit::factory()->create();

        Territory::factory(5)
            ->for($unit)
            ->has(Territory::factory(3)->for($unit), 'parent')
            ->create();


        $department = Department::factory()
            ->for($unit)
            ->count(rand(3,7))
            ->has(Position::factory()
                ->for($unit)
                ->count(rand(2,6))
                ->has(Worker::factory() //TODO department id
                    ->for($unit)
                    ->count(rand(2,6))))
        ->create();


    }
}
