<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Unit\Unit;
use Database\Factories\ActionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
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
            $responsible = $unit->workers->random();

            $action = Action::factory()->create();
            $unit->actions()->save($action);

            $territory->actions()->save($action);
            $worker->actions()->save($action);
            $position->actions()->save($action);
            $department->actions()->save($action);
        }

    }
}
