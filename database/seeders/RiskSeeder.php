<?php
namespace Database\Seeders;

use App\Models\Risk\Risk;
use App\Models\Unit\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unit = Unit::where('id', '>', 1)->get()->random();


        for($counter = 0; $counter < 50 ; $counter++) {
            $territory = $unit->territories->random();
            $worker = $unit->workers->random();
            $position = $worker->position;
            $department = $worker->department;
            $process = $unit->processes->random();
            $product = $unit->products->random();
            $service = $unit->services->random();

            $risk = Risk::factory()
                ->create();

            $risk->units()->save($unit);
            $risk->territories()->save($territory);
            $risk->departments()->save($department);
            $risk->positions()->save($position);
            $risk->processes()->save($process);
            $risk->products()->save($product);
            $risk->services()->save($service);

        }

    }
}
