<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerModel>
 */
class CustomerModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);

        return [
            //
            'customer_username' => $this->faker->userName,
            'customer_password' => Hash::make('dummyCust'),
            'customer_name' => $this->faker->name($gender),
            'customer_address' => $this->faker->address(),
            'customer_phonenumber' => $this->faker->phoneNumber(),
            'customer_gender' => $gender,
            'customer_accountnumber' => $this->faker->unique()->numberBetween(10000000, 9999999999999999)
        ];
    }
}
