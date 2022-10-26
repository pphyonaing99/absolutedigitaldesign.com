<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandtoolAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handtool_assigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('phase_id');
            $table->unsignedBigInteger('user_id')->comment('site eng');
            $table->text('handtool_list')->nullable();
            $table->integer('site_status')->comment('Reach or not to site')->default(0);
            $table->integer('assigned_qty')->comment('record of assigned handtool')->default(0);
            $table->integer('status')->comment('all handtool return or not');
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
        Schema::dropIfExists('handtool_assigns');
    }
}
