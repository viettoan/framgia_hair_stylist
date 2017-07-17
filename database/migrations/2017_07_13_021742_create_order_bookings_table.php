<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('render_booking_id')->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
            $table->string('phone', 100)->nullable();
            $table->string('name', 255);
            $table->integer('stylist_id')->nullable()->unsigned();
            $table->float('grand_total', 15, 2)->default(0);
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
        Schema::dropIfExists('order_bookings');
    }
}
