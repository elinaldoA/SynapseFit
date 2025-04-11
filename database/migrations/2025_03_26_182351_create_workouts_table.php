<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkoutsTable extends Migration
{
    public function up()
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['A', 'B', 'C']);
            $table->foreignId('exercise_id')->constrained('exercises');
            $table->integer('series')->default(3);
            $table->integer('repeticoes')->default(10);
            $table->integer('descanso')->default(60);
            $table->decimal('carga', 8, 2)->nullable();
            $table->date('data_treino')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workouts');
    }
}
