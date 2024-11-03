<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Room::class;
    
    public function definition(): array
    {
        return [
            'nbr' => $this->faker->unique()->numerify('Room ##'),
            'floor' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 50, 300),
            'type' => $this->faker->randomElement(['single', 'double', 'suite']),
            'status' => $this->faker->randomElement(['available', 'reserved', 'maintenance', 'occupied']),
            'description' => $this->faker->paragraph(),
        ];
    }
}
