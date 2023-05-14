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
        Schema::create('scales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airline_id')->references('id')->on('airlines')->onCascade('delete');
            $table->unsignedSmallInteger('year');
            $table->unsignedSmallInteger('fleet')->index();
            $table->decimal('ca_rate', 10, 2)->index();
            $table->decimal('fo_rate', 10, 2)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scales');
    }
};
