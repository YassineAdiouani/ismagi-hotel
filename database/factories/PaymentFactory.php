<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Payment::class;
    
    public function definition(): array
    {
        return [
            'reservation_id' => \App\Models\Reservation::factory(),
            'amount' => $this->faker->randomFloat(2, 20, 1000),
            'payment_date' => $this->faker->date(),
            'payment_method' => $this->faker->randomElement(['credit card', 'cash', 'paypal']),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
        ];
    }
}
