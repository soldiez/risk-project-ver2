<?php

namespace Database\Seeders;

use App\Models\Risk\RiskMethod;
use App\Models\Unit\Department;
use App\Models\Unit\Position;
use App\Models\Unit\Process;
use App\Models\Unit\Product;
use App\Models\Unit\Service;
use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Artisan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OneCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //refresh all tables


        $unit = Unit::factory()->create();


        Territory::factory(5)
            ->for($unit)
            ->create([
                'parent_id' => 1,
            ]);

        for ($ident = 0; $ident <= 10; $ident++) {
            $territory = $unit->territories->random();
            Territory::factory()
                ->for($unit)
                ->for($territory, 'parent')
                ->create();
        }

        $department = Department::factory()
            ->for($unit)
            ->count(random_int(2,5))
            ->has(Position::factory()
                ->for($unit)
                ->count(random_int(2,4)))
        ->create([
            'parent_id' => 1,
        ]);

        for ($ident = 0; $ident <= 5; $ident++) {
            $department = $unit->departments->random();
            Department::factory()
                ->for($unit)
                ->for($department, 'parent')
                ->has(Position::factory()
                    ->for($unit)
                    ->count(random_int(2,4)))
                ->create();
        }
        for ($ident = 0; $ident <= 10; $ident++) {
            $position = $unit->positions->random();
            $department = $position->department;
            Position::factory()
                ->for($unit)
                ->for($position, 'parent')
                ->for($department)
                ->create();
        }

        for ($ident = 0; $ident <= 120; $ident++) {
            $position = $unit->positions->random();
            $department = $position->department;
            Worker::factory()
                ->for($unit)
                ->for($department)
                ->for($position)
                ->create();
        }


        for ($ident = 0; $ident <= 20; $ident++) {

            $territory = $unit->territories->random()->id;
            $worker = $unit->workers->random();
            $positionId = $worker->position->id;
            $departmentId = $worker->department->id;


            $process = Process::factory()->for($unit)->create();
            $product = Product::factory()->for($unit)->create();
            $service = Service::factory()->for($unit)->create();

            DB::table('activity_unit')->insert([
                'process_id' => $process->id,
                'product_id' => $product->id,
                'service_id' => $service->id,
                'worker_id' => $worker->id,
                'position_id' => $positionId,
                'department_id' => $departmentId,
                'territory_id' => $territory,
            ]);
        }

        for ($ident = 0; $ident <= 30; $ident++) {
            $parentProc = $unit->processes->random();
            $parentProd = $unit->products->random();
            $parentServ = $unit->services->random();
            $territory = $unit->territories->random()->id;
            $worker = $unit->workers->random();
            $positionId = $worker->position->id;
            $departmentId = $worker->department->id;

            $process = Process::factory()->for($unit)->for($parentProc, 'parent')->create();
            $product = Product::factory()->for($unit)->for($parentProd, 'parent')->create();
            $service = Service::factory()->for($unit)->for($parentServ, 'parent')->create();

            DB::table('activity_unit')->insert([
                'process_id' => $process->id,
                'product_id' => $product->id,
                'service_id' => $service->id,
                'worker_id' => $worker->id,
                'position_id' => $positionId,
                'department_id' => $departmentId,
                'territory_id' => $territory,
            ]);
        }

        $this->call([
           RiskMethod3x3Seeder::class,
           RiskMethod5x5Seeder::class,
           HazardCategorySeeder::class,
           InjuredBodyPartSeeder::class,
        ]);
        $unit->default_risk_method_id = RiskMethod::where('name', 'like', '5 x 5 method')->first()->id;
        $unit->save();


    }
}
