<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStylistDayoffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stylist_dayoffs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stylist_id')->unsigned();
            $table->date('day');
            $table->string('time');
            $table->integer('status')->default(0);
            $table->mediumText('content');
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
        Schema::dropIfExists('stylist_dayoffs');
    }
}
