<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Reservation::class;
    public function definition(): array
    {
        return [
            'client_id' => \App\Models\Client::factory(),
            'room_id' => \App\Models\Room::factory(),
            'check_in' => $this->faker->date(),
            'check_out' => $this->faker->date(),
            'total_price' => $this->faker->randomFloat(2, 50, 500),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'canceled']),
        ];
    }
}
