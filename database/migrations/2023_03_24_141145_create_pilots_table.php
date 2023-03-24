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
        Schema::create('pilots', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('seniority_number');
            $table->unsignedInteger('employee_number');
            $table->date('doh');
            $table->string('seat');
            $table->string('fleet');
            $table->string('domicile');
            $table->date('retire');
            $table->boolean('active');
            $table->date('month');
            $table->timestamps();

            $table->unique(['seniority_number', 'month']);
            $table->unique(['employee_number', 'month']);
            $table->index(['seat', 'fleet', 'domicile', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilots');
    }
};
