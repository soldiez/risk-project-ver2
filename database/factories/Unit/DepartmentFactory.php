<?php

namespace Database\Factories\Unit;

use App\Models\Unit\Department;
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
            'parent_id' => $this->faker->numberBetween(1, 5),
//                function() {
//            if ($dep = Department::inRandomOrder()->first()) {return $dep->id;}
//             return null;},
            'unit_id' => $this->faker->numberBetween(1, 2),
            'name' => $this->faker->text(15),
            'manager_id' => $this->faker->numberBetween(1, 10),
            'info' => $this->faker->realText,
            'status' => 'active'
        ];
    }
}
