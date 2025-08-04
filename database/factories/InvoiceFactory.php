<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invoiceDate = fake()->dateTimeBetween('-1 year', 'now');
        $dueDate = fake()->dateTimeBetween($invoiceDate, '+1 month');
        $status = fake()->randomElement(['unpaid', 'paid', 'due', 'overdue']);
        
        return [
            'invoice_number' => 'INV-' . str_pad((string)fake()->unique()->numberBetween(1, 9999), 6, '0', STR_PAD_LEFT),
            'customer_id' => Customer::factory(),
            'amount' => fake()->randomFloat(2, 25.00, 250.00),
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'status' => $status,
            'paid_date' => $status === 'paid' ? fake()->dateTimeBetween($invoiceDate, $dueDate) : null,
            'billing_period' => fake()->monthName() . ' ' . fake()->year(),
            'description' => fake()->optional(0.7)->sentence(),
        ];
    }

    /**
     * Indicate that the invoice is unpaid.
     */
    public function unpaid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'unpaid',
            'paid_date' => null,
        ]);
    }

    /**
     * Indicate that the invoice is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid_date' => fake()->dateTimeBetween($attributes['invoice_date'], $attributes['due_date']),
        ]);
    }

    /**
     * Indicate that the invoice is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'overdue',
            'due_date' => fake()->dateTimeBetween('-3 months', '-1 day'),
            'paid_date' => null,
        ]);
    }
}