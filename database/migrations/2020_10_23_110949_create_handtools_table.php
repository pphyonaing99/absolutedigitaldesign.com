<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandtoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handtools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->unsignedBigInteger('brand_id');
            $table->string('serial_number');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('model')->nullable();
            $table->date('purchase_date');
            $table->unsignedBigInteger('shelve_id');
            $table->integer('purchase_price')->default(0);
            $table->integer('selling_price')->default(0);
            $table->text('description')->nullable();
            $table->integer('status')->comment('Assign or not');
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
        Schema::dropIfExists('handtools');
    }
}
