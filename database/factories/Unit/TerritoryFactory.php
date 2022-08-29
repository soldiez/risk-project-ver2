<?php

namespace Database\Factories\Unit;

use App\Models\Unit\Territory;
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
            //
            'parent_id' => $this->faker->numberBetween(1, 5),
            'unit_id' => $this->faker->numberBetween(1, 5),
            'name' => $this->faker->text(15),
            'responsible_id' => $this->faker->numberBetween(1, 9),
            'coordinate' => $this->faker->address,
            'address' => $this->faker->address,
            'info' => $this->faker->sentence,
            'status' => 'active'
        ];
    }
}
