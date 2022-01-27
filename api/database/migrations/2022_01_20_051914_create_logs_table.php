<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('table_id')->constrained();
            $table->foreignId('place_id')->constrained();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->bigInteger('prepayment')->unsigned()->default('0');;
            $table->bigInteger('amount')->unsigned()->default('1');;
            $table->string('date');
            $table->string('time');
            $table->text('note')->nullable();
            $table->text('type');
            $table->text('text');
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
