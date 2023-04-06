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
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('base_seniority');
            $table->unsignedInteger('employee_number');
            $table->string('domicile');
            $table->string('fleet');
            $table->string('seat');
            $table->string('award_domicile');
            $table->string('award_fleet');
            $table->string('award_seat');
            $table->boolean('is_upgrade');
            $table->date('month');
            $table->timestamps();

            $table->index(['award_domicile', 'award_fleet', 'award_seat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awards');
    }
};
