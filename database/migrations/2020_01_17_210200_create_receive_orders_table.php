<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('receive_orders', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('purchase_order_id');
			$table->unsignedBigInteger('employee_id');
			$table->date('arrival_date');
			$table->string('status');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('receive_orders');
	}
}
