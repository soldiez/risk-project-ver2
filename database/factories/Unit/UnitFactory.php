<?php

namespace Database\Factories\Unit;


use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
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
        $name = $this->faker->company;
        $longName = $name . ' Long Name';

        $parentId = Unit::all()->random()->id;



        return [
            //
        'name' => $name,
        'long_name' =>  $longName,
        'phone_main' =>$this->faker->phoneNumber,
        'phone_reserve' => $this->faker->phoneNumber,
        'email' => $this->faker->email,
       // 'manager_id' => Worker::factory()->create()->id,
       // 'manager_phone' => $this->faker->phoneNumber,
       // 'manager_email' => $this->faker->email,
      //     'safety_manager_id' => Worker::factory()->create()->id,
      //  'safety_manager_id' => Worker::all()->random()->id,
       // 'safety_manager_phone' => $this->faker->phoneNumber,
      //  'safety_manager_email' => $this->faker->email,
        'legal_address' => $this->faker->address,
        'post_address' => $this->faker->address,
        'parent_id' => $parentId,
        'status' => 'Active',
        'logo_unit' => $this->faker->image('public/storage/images',400,300, null, false)
        ];
    }
}
