<?php

namespace Database\Factories;

use App\Models\Payment;
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
        $checkInDate = $this->faker->date();
        $checkOutDate = $this->faker->dateTimeBetween($checkInDate, '+1 month')->format('Y-m-d');
        return [
            'client_id' => \App\Models\Client::factory(),
            'room_id' => \App\Models\Room::factory(),
            'check_in' => $checkInDate,
            'check_out' => $checkOutDate,
            'total_price' => $this->faker->randomFloat(2, 50, 500),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'canceled']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Reservation $reservation) {
            Payment::factory()->create([
                'reservation_id' => $reservation->id,
            ]);
        });
    }
}
