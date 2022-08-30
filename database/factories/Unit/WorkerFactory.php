<?php

namespace Database\Factories\Unit;

use App\Models\Unit\Department;
use App\Models\Unit\JobPosition;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Worker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'middle_name'=> $this->faker->firstName,
            'phone'=> $this->faker->phoneNumber,
            'email' => $this->faker->unique->email,
            'personnel_number' => $this->faker->numberBetween([100900, 101000]),
           // 'job_position_id' => JobPosition::all()->random()->id,
           // 'department_id' => Department::all()->random()->id,
           // 'unit_id' => Unit::all()->random()->id,
            'birthday' => $this->faker->date('Y-m-d'),
            'status' => 'Active'
            ];
    }
}
