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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Customer full name');
            $table->string('email')->unique()->comment('Customer email address');
            $table->string('phone')->nullable()->comment('Customer phone number');
            $table->text('address')->comment('Customer address');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->comment('Customer status');
            $table->date('connection_date')->comment('Service connection date');
            $table->foreignId('service_package_id')->constrained();
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('email');
            $table->index('status');
            $table->index('service_package_id');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};