<?php

namespace Database\Factories\Unit;

use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class TerritoryFactory extends Factory
{
    protected $model = Territory::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          //  'parent_id' => Territory::all()->random()->id,
          //  'unit_id' => Unit::all()->random()->id,
            'name' => $this->faker->text(15),
          //  'responsible_id' => Worker::all()->random()->id,
            'coordinate' => $this->faker->address,
            'address' => $this->faker->address,
            'info' => $this->faker->sentence,
            'status' => 'Active'
        ];
    }
}
