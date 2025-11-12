<?php

namespace Modules\Addresses\Database\factories;

use App\Enums\AddressTypesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Addresses\Entities\Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = random_or_create(\Modules\Accounts\Entities\User::class);
        $types = AddressTypesEnum::values();

        return [
            'address' => $this->faker->address,
            'lat' => $this->faker->latitude,
            'long' => $this->faker->longitude,
            'user_id' => $user->id,
            'type' => $types[array_rand($types)],
            'is_default' => true,
        ];
    }
}
