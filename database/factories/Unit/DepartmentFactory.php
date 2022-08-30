<?php

namespace Database\Factories\Unit;

use App\Models\Unit\Department;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        //    'parent_id' => Department::all()->random()->id,
//                function() {
//            if ($dep = Department::inRandomOrder()->first()) {return $dep->id;}
//             return null;},
        //    'unit_id' => Unit::all()->random()->id,
            'name' => $this->faker->text(15),
        //    'manager_id' => Worker::all()->random()->id,
            'info' => $this->faker->realText,
            'status' => 'Active'
        ];
    }
}
