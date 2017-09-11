<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_booking_id')->nullable()->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
            $table->smallInteger('old_status');
            $table->smallInteger('new_status');
            $table->text('message', 400);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_status');
    }
}
