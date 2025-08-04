<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\ServicePackage;
use Illuminate\Database\Seeder;

class IspSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create service packages first
        $packages = ServicePackage::factory(8)->create([
            'is_active' => true,
        ]);

        // Create some inactive packages
        ServicePackage::factory(2)->inactive()->create();

        // Create customers with existing packages
        $customers = Customer::factory(25)->create([
            'service_package_id' => fn() => $packages->random()->id,
            'status' => 'active',
        ]);

        // Create some inactive/suspended customers
        Customer::factory(5)->inactive()->create([
            'service_package_id' => fn() => $packages->random()->id,
        ]);

        Customer::factory(3)->suspended()->create([
            'service_package_id' => fn() => $packages->random()->id,
        ]);

        // Create invoices for customers
        $customers->each(function ($customer) {
            // Create 3-6 invoices per customer
            $invoiceCount = random_int(3, 6);
            
            for ($i = 0; $i < $invoiceCount; $i++) {
                $invoice = Invoice::factory()->create([
                    'customer_id' => $customer->id,
                    'amount' => $customer->servicePackage->price,
                    'billing_period' => now()->subMonths($i)->format('F Y'),
                    'invoice_date' => now()->subMonths($i)->startOfMonth(),
                    'due_date' => now()->subMonths($i)->startOfMonth()->addDays(15),
                ]);

                // 80% chance of payment for older invoices
                if ($i > 0 && fake()->boolean(80)) {
                    Payment::factory()->create([
                        'invoice_id' => $invoice->id,
                        'customer_id' => $customer->id,
                        'amount' => $invoice->amount,
                        'payment_date' => fake()->dateTimeBetween($invoice->invoice_date, $invoice->due_date),
                    ]);

                    $invoice->update([
                        'status' => 'paid',
                        'paid_date' => fake()->dateTimeBetween($invoice->invoice_date, $invoice->due_date),
                    ]);
                }
            }
        });

        // Create some overdue invoices
        Invoice::factory(8)->overdue()->create([
            'customer_id' => fn() => $customers->random()->id,
        ]);

        // Update invoice statuses based on due dates
        Invoice::where('status', 'unpaid')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);

        Invoice::where('status', 'unpaid')
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(7))
            ->update(['status' => 'due']);
    }
}