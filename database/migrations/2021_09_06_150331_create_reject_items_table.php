<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejectItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reject_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grn_id');
            $table->integer('do_id');
            $table->integer('product_id');
            $table->date('reject_date');
            $table->integer('type');
            $table->integer('reject_qty');
            $table->string('supplier');
            $table->string('remark');
          
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
        Schema::dropIfExists('reject_items');
    }
}
