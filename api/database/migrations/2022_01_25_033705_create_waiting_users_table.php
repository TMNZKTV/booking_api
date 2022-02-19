<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaitingUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waiting_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('table')->nullable()->constrained();
            $table->foreignId('place_id')->nullable()->constrained();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->bigInteger('prepayment')->unsigned()->default('0');
            $table->bigInteger('amount')->unsigned()->default('1');
            $table->string('date');
            $table->string('time', 255)->nullable()->change();
            $table->string('note', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waiting_users');
    }
}
