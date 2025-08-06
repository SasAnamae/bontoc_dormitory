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
            $table->date('payment_date')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('or_number')->unique();
            $table->text('remarks')->nullable();
            $table->enum('status', ['Confirmed'])->default('Confirmed');
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('cashier_id')->nullable()->constrained('users')->onDelete('set null');

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
