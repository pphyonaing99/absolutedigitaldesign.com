<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTaskListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_task_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('report_task_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('stock_qty');
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
        Schema::dropIfExists('report_task_lists');
    }
}
