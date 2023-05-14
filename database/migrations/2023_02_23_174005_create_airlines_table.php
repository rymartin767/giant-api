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
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('sector')->index();
            $table->string('name')->unique();
            $table->string('icao')->unique()->index();
            $table->string('iata')->unique();
            $table->unsignedSmallInteger('union');
            $table->unsignedInteger('pilot_count');
            $table->boolean('is_hiring');
            $table->string('web_url');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airlines');
    }
};
