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
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Package name');
            $table->string('speed')->comment('Internet speed (e.g., 100 Mbps)');
            $table->decimal('price', 10, 2)->comment('Monthly price');
            $table->text('description')->nullable()->comment('Package description');
            $table->boolean('is_active')->default(true)->comment('Package availability status');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('is_active');
            $table->index(['is_active', 'price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};