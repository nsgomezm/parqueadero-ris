<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cedula');
            $table->string('name');
            $table->string('last_name');
            $table->string('cel');
            $table->string('address');
            $table->string('comments');
            $table->unsignedBigInteger('parking_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('parking_id')->references('id')->on('parkings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
