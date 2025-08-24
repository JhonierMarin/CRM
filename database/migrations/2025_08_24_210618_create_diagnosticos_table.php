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
    Schema::create('diagnosticos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre')->nullable();
        $table->unsignedInteger('edad')->nullable();
        $table->string('genero', 10)->nullable();
        $table->json('entrada');
        $table->string('resultado');
        $table->string('nivel')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosticos');
    }
};
