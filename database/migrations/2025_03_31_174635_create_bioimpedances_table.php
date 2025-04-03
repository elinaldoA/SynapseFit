<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBioimpedancesTable extends Migration
{
    /**
     * Execute as the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bioimpedances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('imc', 5, 2);
            $table->decimal('peso_ideal_inferior', 5, 2);
            $table->decimal('peso_ideal_superior', 5, 2);
            $table->decimal('massa_magra', 5, 2);
            $table->decimal('percentual_gordura', 5, 2);
            $table->decimal('massa_gordura', 5, 2);
            $table->decimal('agua_corporal', 5, 2);
            $table->decimal('visceral_fat', 5, 2);
            $table->decimal('idade_corporal', 5, 2);
            $table->float('bmr');
            $table->decimal('massa_muscular', 5, 2)->nullable();
            $table->decimal('massa_ossea', 5, 2)->nullable();
            $table->timestamp('data_medicao')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bioimpedances');
    }
}
