<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation_sieges', function (Blueprint $table) {
            $table->id();

            // Since siege_nom is a string PK in sieges, use string here
            $table->string('siege_nom');
            $table->unsignedBigInteger('reservation_id');

            // Foreign keys
            $table->foreign('siege_nom')->references('nom')->on('sieges')->cascadeOnDelete();
            $table->foreign('reservation_id')->references('id')->on('reservations')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_sieges');
    }
};
