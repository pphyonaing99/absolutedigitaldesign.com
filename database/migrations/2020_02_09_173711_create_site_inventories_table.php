<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteInventoriesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('site_inventories', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_id');
			$table->string('model_number');
			$table->string('measuring_unit');
			$table->string('name');
			$table->string('brand_name');
			$table->integer('delivered_qty');
			$table->string('location');
			$table->date('received_date')->nullable();
			$table->unsignedBigInteger('project_id');
			$table->unsignedBigInteger('phase_id');
			$table->integer('flag');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('site_inventories');
	}
}
