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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code',10)->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->decimal('shipping_price', 10, 2)->default(35);
            $table->decimal('total_price', 10, 2)->default(0);
            $table->string('shipping_agency', 50);
            $table->string('status', 20)->default('Préparation');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
