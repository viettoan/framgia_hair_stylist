<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeSheetDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_sheet_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mon', 255);
            $table->string('tues', 255);
            $table->string('wed', 255);
            $table->string('thur', 255);
            $table->string('fri', 255);
            $table->string('sat', 255);
            $table->string('sun', 255);
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
        Schema::dropIfExists('time_sheet_departments');
    }
}
