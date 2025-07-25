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
        Schema::create('rooms', function (Blueprint $table) {
             $table->id();
            $table->foreignId('dormitory_id')->constrained()->onDelete('cascade');
            $table->string('name'); 
            $table->longText('photo')->nullable(); 
            $table->enum('bed_type', ['Single', 'Double Deck']);
            $table->integer('num_decks')->default(0);
            $table->integer('total_beds')->default(0);
            $table->integer('occupied_beds')->default(0);
            $table->integer('available_beds')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
