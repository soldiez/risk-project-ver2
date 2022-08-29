<?php

namespace Database\Factories\Unit;


use App\Models\Unit\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        'short_name' => $this->faker->company,
        'long_name' =>  $this->faker->company, //TODO сделать длинное имя на основе короткого
        'phone_main' =>$this->faker->phoneNumber,
        'phone_reserve' => $this->faker->phoneNumber,
        'email' => $this->faker->email,
        'manager_id' => $this->faker->numberBetween(1, 5), //TODO make links
       // 'manager_phone' => $this->faker->phoneNumber,
       // 'manager_email' => $this->faker->email,
        'safety_manager_id' => $this->faker->numberBetween(1, 5), //TODO make links
       // 'safety_manager_phone' => $this->faker->phoneNumber,
      //  'safety_manager_email' => $this->faker->email,
        'legal_address' => $this->faker->address,
        'post_address' => $this->faker->address,
        'parent_id' => $this->faker->numberBetween(1, 5), //TODO сделать связь с другими компаниями
        'status' => 'active',
        'logo_unit' => $this->faker->image(public_path('images'),640,480, null, false)
        ];
    }
}
