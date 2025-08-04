<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Invoice;
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
    public function definition(): array
    {
        $invoice = Invoice::factory()->create();
        
        return [
            'invoice_id' => $invoice->id,
            'customer_id' => $invoice->customer_id,
            'amount' => $invoice->amount,
            'payment_date' => fake()->dateTimeBetween($invoice->invoice_date, 'now'),
            'payment_method' => fake()->randomElement(['cash', 'bank_transfer', 'credit_card', 'debit_card', 'check']),
            'reference_number' => fake()->optional(0.8)->bothify('TXN-########'),
            'notes' => fake()->optional(0.2)->sentence(),
        ];
    }

    /**
     * Indicate that the payment was made by cash.
     */
    public function cash(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => 'cash',
            'reference_number' => null,
        ]);
    }

    /**
     * Indicate that the payment was made by bank transfer.
     */
    public function bankTransfer(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => 'bank_transfer',
            'reference_number' => fake()->bothify('BT-########'),
        ]);
    }

    /**
     * Indicate that the payment was made by credit card.
     */
    public function creditCard(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => 'credit_card',
            'reference_number' => fake()->bothify('CC-########'),
        ]);
    }
}