<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->unique()->companyEmail(),
            'description' => $this->faker->optional()->sentence(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
