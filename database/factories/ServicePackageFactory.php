<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServicePackage>
 */
class ServicePackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $speeds = ['10 Mbps', '25 Mbps', '50 Mbps', '100 Mbps', '200 Mbps', '500 Mbps', '1 Gbps'];
        $names = ['Basic', 'Standard', 'Premium', 'Ultra', 'Enterprise', 'Starter', 'Pro'];
        
        return [
            'name' => fake()->randomElement($names) . ' ' . fake()->randomElement(['Plan', 'Package', 'Bundle']),
            'speed' => fake()->randomElement($speeds),
            'price' => fake()->randomFloat(2, 19.99, 199.99),
            'description' => fake()->sentence(random_int(8, 15)),
            'is_active' => fake()->boolean(90), // 90% chance of being active
        ];
    }

    /**
     * Indicate that the service package is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the service package is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}