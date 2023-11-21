<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
final class CommunityManagersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'manager_id' => $this->faker->unique()->numberBetween(1, 11),
            'community_id' => $this->faker->unique()->numberBetween(1, 16),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
