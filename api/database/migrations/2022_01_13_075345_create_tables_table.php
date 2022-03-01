<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('place_id')->constrained();
            $table->bigInteger('x')->unsigned()->default('0');
            $table->bigInteger('y')->unsigned()->default('0');;
            $table->bigInteger('w')->unsigned()->default('1');;
            $table->bigInteger('h')->unsigned()->default('2');;
            $table->string('i', );
            $table->boolean('bbq')->default(false);
            $table->boolean('restriction')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables');
    }
}
