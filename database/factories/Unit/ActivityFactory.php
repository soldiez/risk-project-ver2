<?php

namespace Database\Factories\Unit;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'type' => array_rand(['Process'=>'Process','Product'=>'Product','Service'=>'Service']),
            'name' => $this->faker->text(15),
            'description' => $this->faker->realText(100),
            'status' => 'Active',
        ];
    }
}
