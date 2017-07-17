<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments');
        });

        Schema::table('department_dayoffs', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments');
        });

        Schema::table('order_bookings', function (Blueprint $table) {
            $table->foreign('render_booking_id')->references('id')->on('render_bookings');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('stylist_id')->references('id')->on('users');
        });

        Schema::table('time_sheet_stylists', function (Blueprint $table) {
             $table->foreign('stylist_id')->references('id')->on('users');
        });

        Schema::table('stylist_dayoffs', function (Blueprint $table) {
            $table->foreign('stylist_id')->references('id')->on('users');
        });

        Schema::table('render_bookings', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('order_bookings');
            $table->foreign('service_product_id')->references('id')->on('service_products');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });

        Schema::table('department_dayoffs', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });

        Schema::table('order_bookings', function (Blueprint $table) {
            $table->dropForeign(['render_booking_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['stylist_id']);
        });

        Schema::table('time_sheet_stylists', function (Blueprint $table) {
             $table->dropForeign(['stylist_id']);
        });

        Schema::table('stylist_dayoffs', function (Blueprint $table) {
            $table->dropForeign(['stylist_id']);
        });

        Schema::table('render_bookings', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['service_product_id']);
        });
    }
}
