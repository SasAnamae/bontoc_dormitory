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
        Schema::create('occupant_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('course_section')->nullable();
        $table->string('home_address')->nullable();
        $table->string('cellphone')->nullable();
        $table->string('email')->nullable();
        $table->date('birthday')->nullable();
        $table->integer('age')->nullable();
        $table->string('religion')->nullable();
        $table->string('scholarship')->nullable();
        $table->string('blood_type')->nullable();
        $table->string('allergies')->nullable();
        $table->string('father_fullname')->nullable();
        $table->string('father_phone')->nullable();
        $table->string('mother_fullname')->nullable();
        $table->string('mother_phone')->nullable();
        $table->text('electrical_appliances')->nullable();
        $table->decimal('total_monthly', 8, 2)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupant_profiles');
    }
};
