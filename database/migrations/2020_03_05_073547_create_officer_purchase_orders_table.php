<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficerPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officer_purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('po_no');
            $table->string('delivery_address')->nullable();
            $table->string('item_list')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->integer('warehouse_status')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('officer_purchase_orders');
    }
}
