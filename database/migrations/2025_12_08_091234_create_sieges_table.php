<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sieges', function (Blueprint $table) {
            $table->string('nom')->primary();
            $table->string('prix_type');
            $table->unsignedBigInteger('salle_id');

            $table->foreign('prix_type')->references('type')->on('prixes')->onDelete('cascade');
            $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sieges');
    }
};
