<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficerPurchaseOrderListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officer_purchase_order_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('officer_purchase_order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('purchase_request_id')->unsigned();
            $table->integer('order_qty');
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
        Schema::dropIfExists('officer_purchase_order_lists');
    }
}
