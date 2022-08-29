<?php

namespace Database\Factories\Unit;

use App\Models\Unit\JobPosition;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPositionFactory extends Factory
{
    protected $model = JobPosition::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'parent_id'=> $this->faker->numberBetween(1, 4),
            'department_id'=> $this->faker->numberBetween(1,9),
            'unit_id' => $this->faker->numberBetween(1, 2),
            'name' => $this->faker->text(15),
            'grade' => $this->faker->numberBetween(1, 10),
            'info' => $this->faker->sentence,
            'status' => 'active'
        ];
    }
}
