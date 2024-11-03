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
            $table->string('nbr')->nullable(false);
            $table->integer('floor')->nullable(false);
            $table->decimal('price', 10, 2)->nullable(false);
            $table->enum('type', ['single', 'double', 'suite'])->nullable(false);
            $table->enum('status', ['available', 'reserved', 'maintenance', 'occupied'])->nullable(false);
            $table->text('description')->nullable();
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
