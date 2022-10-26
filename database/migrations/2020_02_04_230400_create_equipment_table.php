<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('equipment', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('serial_number');
			$table->string('name');
			$table->integer('stock_qty');
			$table->string('brand_name');
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
		Schema::dropIfExists('equipment');
	}
}
