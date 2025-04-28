<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jejuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('protocolo');
            $table->integer('duracao_jejum');
            $table->time('inicio');
            $table->time('fim')->nullable();
            $table->string('objetivo');
            $table->decimal('peso_atual', 5, 2)->nullable();
            $table->decimal('peso_meta', 5, 2);
            $table->boolean('jejum_previamente_feito')->default(false);
            $table->boolean('doenca_cronica')->default(false);
            $table->string('descricao_doenca')->nullable();
            $table->string('outra_doenca')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('status')->default('inativo');
            $table->timestamp('pausado_em')->nullable();
            $table->integer('tempo_decorrido')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jejuns');
    }
};
