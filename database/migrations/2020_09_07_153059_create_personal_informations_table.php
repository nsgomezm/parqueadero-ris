<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cedula');
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->bigInteger('cel')->nullable();
            $table->string('photo')->default('/images/persons/admins/noimage.png');
            $table->string('address')->nullable();
            $table->string('comments')->default('Sin comentarios');
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_informations');
    }
}
