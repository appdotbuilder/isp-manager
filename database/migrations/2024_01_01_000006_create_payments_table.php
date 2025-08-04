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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained();
            $table->foreignId('customer_id')->constrained();
            $table->decimal('amount', 10, 2)->comment('Payment amount');
            $table->date('payment_date')->comment('Payment date');
            $table->string('payment_method')->comment('Payment method (cash, bank transfer, etc.)');
            $table->string('reference_number')->nullable()->comment('Payment reference/transaction number');
            $table->text('notes')->nullable()->comment('Payment notes');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('invoice_id');
            $table->index('customer_id');
            $table->index('payment_date');
            $table->index('payment_method');
            $table->index(['customer_id', 'payment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};