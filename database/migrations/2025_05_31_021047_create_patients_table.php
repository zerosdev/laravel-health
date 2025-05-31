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
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->string('name');
            $table->enum('id_type', ['id_card', 'driving_license']);
            $table->string('id_no');
            $table->enum('gender', ['male', 'female']);
            $table->date('dob');
            $table->text('address');
            $table->string('medium_acquisition')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
