<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 191)->unique();
            $table->string('phone', 100)->nullable();
            $table->string('password');
            $table->date('birthday')->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('gender')->nullable();
            $table->integer('permission')->default(0);
            $table->mediumText('experience')->nullable();
            $table->string('specialize')->nullable();
            $table->mediumText('about_me')->nullable();
            $table->integer('department_id')->nullable()->unsigned();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
