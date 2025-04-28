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
        Schema::create('alimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->enum('refeicao', ['café', 'almoço', 'lanche', 'jantar']);
            $table->float('calorias');
            $table->float('proteinas');
            $table->float('carboidratos');
            $table->float('gorduras');
            $table->float('fibras')->nullable();
            $table->float('sodio')->nullable();
            $table->float('agua')->nullable();
            $table->string('porcao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos');
    }
};
