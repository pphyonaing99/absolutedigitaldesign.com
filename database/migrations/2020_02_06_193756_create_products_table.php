<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('products', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('brand_id');
			$table->unsignedBigInteger('shelve_id')->nullable();
			$table->string('model_number');
			$table->string('measuring_unit');
			$table->string('name');
			$table->integer('stock_qty');
			$table->string('reorder_qty');
			$table->string('minnimum_order_qty');
			$table->string('purchase_price');
			$table->string('retail_price');
			$table->string('wholesale_price');
			$table->integer('discount_flag');
			$table->integer('discount_type');
			$table->string('location');
			$table->date('reg_date');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('products');
	}
}
