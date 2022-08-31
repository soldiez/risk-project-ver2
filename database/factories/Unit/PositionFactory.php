<?php

namespace Database\Factories\Unit;

use App\Models\Unit\Department;
use App\Models\Unit\Position;
use App\Models\Unit\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    protected $model = Position::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
          //  'parent_id'=> Position::all()->random()->id,
          //  'department_id'=> Department::all()->random()->id,
          //  'unit_id' => Unit::all()->random()->id,
            'name' => $this->faker->jobTitle(),
            'grade' => $this->faker->numberBetween(1, 10),
            'info' => $this->faker->sentence,
            'status' => 'Active'
        ];
    }
}
