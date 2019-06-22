<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ip')->nullable(false);
            $table->timestamp('data')->nullable(false);
            $table->text('url')->nullable();
            $table->unsignedBigInteger('agent_id')->nullable(false);
            $table->foreign('agent_id', 'fg_logs_agent_id')
                ->references('id')
                ->on('user_agents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
