<?php
namespace Database\Seeders;

use App\Models\Risk\Risk;
use App\Models\Unit\Department;
use App\Models\Unit\Position;
use App\Models\Unit\Process;
use App\Models\Unit\Product;
use App\Models\Unit\Service;
use App\Models\Unit\Territory;
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
        $unit = Unit::where('id', '>', 1)->first();

        for($counter = 0; $counter < 50 ; $counter++) {
            $territory = $unit->territories->random();
            $worker = $unit->workers->random();
            $position = $worker->position;
            $department = $worker->department;
            $activity = $unit->activities->random();

            $risk = Risk::factory()
                ->create();

            $unit->risks()->save($risk);
            $territory->risks()->save($risk);
            $department->risks()->save($risk);
            $position->risks()->save($risk);
            $activity->risks()->save($risk);
        }
    }
}
