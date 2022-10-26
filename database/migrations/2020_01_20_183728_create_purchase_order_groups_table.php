<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderGroupsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

	public function up() {
		Schema::create('purchase_order_groups', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('group_id');
			$table->string('group_name');
			$table->unsignedBigInteger('purchase_order_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('purchase_order_groups');
	}
}
