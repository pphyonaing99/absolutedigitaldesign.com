<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandtoolListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handtool_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('handtool_assign_id');
            $table->unsignedBigInteger('user_id')->comment('history User');
            $table->unsignedBigInteger('hand_tool_id');
            $table->date('assigned_date');
            $table->date('return_date')->nullable();
            $table->integer('status')->comment('returned or not');
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
        Schema::dropIfExists('handtool_lists');
    }
}
