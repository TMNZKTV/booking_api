<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletedReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('completed_reservations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->boolean('conflict')->default(0);
            $table->string('visit_type')->default('none');
            $table->bigInteger('amount')->unsigned()->default('1');
            $table->string('note')->nullable();
            $table->bigInteger('prepayment')->unsigned()->default('0');
            $table->foreignId('table_id')->constrained();
            $table->foreignId('place_id')->constrained();
            $table->date('date');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('responsible_email')->nullable();
            $table->string('responsible_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('completed_reservations');
    }
}
