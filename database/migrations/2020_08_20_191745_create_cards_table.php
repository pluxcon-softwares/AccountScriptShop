<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned();
            $table->string('card_type')->nullable();
            $table->bigInteger('card_number')->nullable();
            $table->integer('bin')->nullable();
            $table->string('exp')->nullable();
            $table->string('holder')->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('dob')->nullable();
            $table->string('ssn')->nullable();
            $table->string('zip')->nullable();
            $table->string('base')->nullable();
            $table->decimal('price', 9, 2)->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
