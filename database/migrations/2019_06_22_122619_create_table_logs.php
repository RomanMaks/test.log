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
            $table->bigInteger('ip')->nullable(false);
            $table->timestamp('date')->nullable(false);
            $table->text('url')->nullable();
            $table->string('os', 20)->nullable();
            $table->string('architecture', 3)->nullable();
            $table->string('browser')->nullable();
            $table->index(['ip'], 'idx_logs_ip');
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
