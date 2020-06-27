<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code');
            $table->longText('description');
            $table->float('price', 10, 2);
            $table->enum('isactive', ['on', 'off']);	
            $table->date('created_date');
            $table->string('created_by');
            $table->date('updated_date');	
            $table->string('updated_by');
            $table->date('deleted_date');
            $table->string('deleted_by');
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
        Schema::dropIfExists('price');
    }
}
