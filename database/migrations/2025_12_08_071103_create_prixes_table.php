<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prixes', function (Blueprint $table) {
            $table->string('type')->primary();
            $table->integer('prix');
            // No timestamps, because model has $timestamps = false
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prixes');
    }
};
