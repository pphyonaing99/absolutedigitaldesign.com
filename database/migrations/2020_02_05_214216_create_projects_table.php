<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('projects', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('project_name');
			$table->string('customer');
			$table->string('description');
			$table->string('location');
			$table->date('start_date');
			$table->date('end_date');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('projects');
	}
}
