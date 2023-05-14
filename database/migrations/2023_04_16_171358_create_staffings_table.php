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
        Schema::create('staffings', function (Blueprint $table) {
            $table->id();
            $table->date('list_date')->unique();
            $table->integer('total_pilot_count');
            $table->integer('active_pilot_count');
            $table->integer('inactive_pilot_count');
            $table->integer('net_gain_loss');
            $table->integer('ytd_gain_loss');
            $table->integer('average_age');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffings');
    }
};
