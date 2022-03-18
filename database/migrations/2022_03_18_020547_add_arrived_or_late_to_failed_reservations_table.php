<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArrivedOrLateToFailedReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('failed_reservations', function (Blueprint $table) {
            $table->boolean('arrived')->default('0');
            $table->boolean('late')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('failed_reservations', function (Blueprint $table) {
            $table->dropColumn('arrived');
            $table->dropColumn('late');
        });
    }
}
