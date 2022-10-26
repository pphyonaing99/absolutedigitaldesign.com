<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehoueTransferOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehoue_transfer_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('warehoue_transfer_no');
            $table->string('receive_person');
            $table->string('phone');
			$table->integer('wto_regional_id');
			$table->integer('wto_project_id');
			$table->date('date');
            $table->integer('total_qty');
            
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
        Schema::dropIfExists('warehoue_transfer_orders');
    }
}
