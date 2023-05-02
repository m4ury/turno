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
        Schema::create('camas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_cama')->unsigned()->nullable();
            $table->enum('estado_cama', ['ocupada', 'disponible', 'bloqueada', 'pre-alta'])->nullable();
            $table->foreignId('sala_id')->references('id')->on('salas')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camas');
    }
};
