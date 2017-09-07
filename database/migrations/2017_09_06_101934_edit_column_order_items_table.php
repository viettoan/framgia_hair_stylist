<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('stylist_id')->unsigned();
            $table->float('discount', 15, 2)->default(0);
            $table->float('row_total', 15, 2);
            $table->integer('qty')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('stylist_id');
            $table->dropColumn('discount');
            $table->dropColumn('row_total');
            $table->dropColumn('qty');
        });
    }    
}
