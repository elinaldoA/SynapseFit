<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlimentacoesTable extends Migration
{
    public function up()
    {
        Schema::create('alimentacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('refeicao', ['café', 'almoço', 'lanche', 'jantar']);
            $table->float('calorias');
            $table->float('proteinas');
            $table->float('carboidratos');
            $table->float('gorduras');
            $table->float('agua')->nullable();
            $table->float('fibras')->nullable();
            $table->float('sodio')->nullable();
            $table->text('descricao')->nullable();
            $table->date('data');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('alimentacoes');
    }
}
