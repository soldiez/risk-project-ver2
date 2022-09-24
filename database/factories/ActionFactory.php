<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Action>
 */
class ActionFactory extends Factory
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
            'type' => array_rand(['Safety'=>'Safety', 'Health'=>'Health','Ecology'=>'Ecology']),
            'name' => $this->faker->text(20),
            'description' => $this->faker->realText(150),
            'plan_date' => now(),
            'start_date' => now(),
            'due_date' => now(),
            'photo_before' => $this->faker->image,
            'photo_after' => $this->faker->image,
            'status' => 'Active',
        ];
    }
}
