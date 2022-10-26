<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejectListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reject_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('grn_no');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('good_receive_note_id');
            $table->string('regional_name')->nullable();
            $table->string('date');
            $table->integer('type');
            $table->integer('warehouse_flag');
            $table->integer('quantity');
            $table->string('category_name');
            $table->string('supplier');
            $table->integer('purchase_price');
            $table->unsignedBigInteger('project_phase_id')->nullable();
            $table->unsignedBigInteger('work_site_id')->nullable();
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
        Schema::dropIfExists('reject_lists');
    }
}
