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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('environment_id');
            $table->date('date');
            $table->time('startTime');
            $table->time('endTime');
            $table->boolean("handOveredKeys")->default(false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('environment_id')->references('id')->on('environments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("schedules");
    }
};
