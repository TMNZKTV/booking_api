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
            $table->foreignId('table_id')->nullable()->constrained();
            $table->foreignId('place_id')->nullable()->constrained();
            $table->string('name');
            $table->string('phone');
            $table->boolean('prepayment');
            $table->bigInteger('amount')->default(1);
            $table->string('date');
            $table->string('time')->nullable()->default('NULL');
            $table->string('note', 255)->nullable()->default('NULL');
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
