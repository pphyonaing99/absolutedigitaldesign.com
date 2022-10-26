<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodReceiveNoteWarehousePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_receive_note_warehouse_purchase_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('good_receive_note_id');
            $table->unsignedBigInteger('warehouse_purchase_order_id');
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
        Schema::dropIfExists('good_receive_note_warehouse_purchase_order');
    }
}
