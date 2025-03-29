<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDietasTable extends Migration
{
    public function up()
    {
        Schema::create('dietas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacionamento com a tabela 'users'
            $table->decimal('calorias', 8, 2);
            $table->decimal('proteinas', 8, 2);
            $table->decimal('carboidratos', 8, 2);
            $table->decimal('gorduras', 8, 2);
            $table->text('suplementos');
            $table->decimal('agua', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dietas');
    }
}
