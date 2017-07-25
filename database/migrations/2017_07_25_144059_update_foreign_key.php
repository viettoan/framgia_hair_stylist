<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('users');
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->foreign('order_booking_id')->references('id')->on('order_bookings');
        });

        Schema::table('bill_items', function (Blueprint $table) {
            $table->foreign('bill_id')->references('id')->on('bills');
        });

        Schema::table('bill_items', function (Blueprint $table) {
            $table->foreign('service_product_id')->references('id')->on('service_products');
        });

        Schema::table('bill_items', function (Blueprint $table) {
            $table->foreign('stylist_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->dropForeign(['order_booking_id']);
        });

        Schema::table('bill_items', function (Blueprint $table) {
            $table->dropForeign(['bill_id']);
        });

        Schema::table('bill_items', function (Blueprint $table) {
            $table->dropForeign(['service_product_id']);
        });

        Schema::table('bill_items', function (Blueprint $table) {
            $table->dropForeign(['stylist_id']);
        });
    }
}
