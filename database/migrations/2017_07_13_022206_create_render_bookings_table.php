<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenderBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('render_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->date('day');
            $table->time('time_start');
            $table->integer('total_slot');
            $table->integer('status')->default(1);
            $table->integer('department_id')->nullable()->unsigned();
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
        Schema::dropIfExists('render_bookings');
    }
}
