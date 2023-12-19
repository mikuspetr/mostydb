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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->foreignId('place_id');
            $table->foreignId('form_id')->nullable();
            $table->foreignId('kind_id')->nullable();
            $table->foreignId('type_id')->nullable();
            $table->smallInteger('duration')->nullable();
            $table->smallInteger('duration_pp')->nullable();
            $table->boolean('intervention');
            $table->foreignId('status_id')->nullable();
            $table->text('text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
