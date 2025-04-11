<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->morphs('notifiable');
            $table->string('type');
            $table->text('data');
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('read_at')->nullable();

            // Indexes para o relacionamento
            $table->index('notifiable_id');
            $table->index('notifiable_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
