<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlimentacoesTable extends Migration
{
    public function up()
    {
        Schema::create('alimentacoes', function (Blueprint $table) {
            $table->id(); // ID único para cada item de alimentação
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacionamento com o usuário
            $table->string('alimento'); // Nome do alimento ou bebida consumido
            $table->decimal('quantidade', 8, 2); // Quantidade consumida (gramas ou ml)
            $table->decimal('calorias', 8, 2); // Calorias do alimento consumido
            $table->decimal('proteinas', 8, 2); // Proteínas do alimento consumido
            $table->decimal('carboidratos', 8, 2); // Carboidratos do alimento consumido
            $table->decimal('gorduras', 8, 2); // Gorduras do alimento consumido
            $table->decimal('agua', 8, 2); // Quantidade de água associada ao alimento
            $table->timestamps(); // Campos para controle de data e hora
        });
    }

    public function down()
    {
        Schema::dropIfExists('alimentacoes');
    }
}
