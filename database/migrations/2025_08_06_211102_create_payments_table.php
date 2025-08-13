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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payment_month');
            $table->decimal('amount', 10, 2);
            $table->decimal('dorm_fee', 10, 2)->default(500);
            $table->string('appliances')->nullable();
            $table->decimal('appliance_fee', 10, 2)->default(0);
            $table->string('or_number')->unique()->nullable();
            $table->dateTime(column: 'paid_at')->nullable();
            $table->longText('receipt_photo')->nullable();
            $table->enum('status', ['pending', 'verified'])->default('pending');
            $table->timestamps();
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
