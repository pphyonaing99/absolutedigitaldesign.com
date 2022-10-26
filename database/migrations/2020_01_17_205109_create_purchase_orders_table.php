<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('purchase_orders', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('order_code')->nullable();
			$table->string('project_name');
			$table->string('customer_name');
			$table->string('phone');
			$table->date('request_date');
			$table->text('item_list');
			$table->integer('site_status');
			$table->integer('warehouse_status')->nullable();
			$table->unsignedBigInteger('work_site_id');
			$table->date('eta_date')->nullable();
			$table->date('dispatch_date')->nullable();
			$table->date('receive_date')->nullable();
			$table->integer('status')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('purchase_orders');
	}
}
