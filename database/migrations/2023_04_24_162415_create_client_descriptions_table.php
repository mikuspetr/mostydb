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
        Schema::create('client_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->text('first_contact')->nullable();
            $table->text('personal')->nullable();
            $table->text('social')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_descriptions');
    }
};
