<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->comment('Unique invoice number');
            $table->foreignId('customer_id')->constrained();
            $table->decimal('amount', 10, 2)->comment('Invoice amount');
            $table->date('invoice_date')->comment('Invoice generation date');
            $table->date('due_date')->comment('Payment due date');
            $table->enum('status', ['unpaid', 'paid', 'due', 'overdue'])->default('unpaid')->comment('Payment status');
            $table->date('paid_date')->nullable()->comment('Payment completion date');
            $table->string('billing_period')->comment('Billing period (e.g., January 2024)');
            $table->text('description')->nullable()->comment('Invoice description');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('invoice_number');
            $table->index('customer_id');
            $table->index('status');
            $table->index('due_date');
            $table->index(['status', 'due_date']);
            $table->index(['customer_id', 'billing_period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};