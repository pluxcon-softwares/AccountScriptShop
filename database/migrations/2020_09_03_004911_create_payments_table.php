<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->unsigned();
            $table->string('customer_name')->nullable();
            $table->string('address', 100)->nullable();
            $table->string('code')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('state')->default('created');
            $table->float('local_amount', 9, 2)->default(0.00);
            $table->string('local_currency')->default('USD');
            $table->float('bitcoin_amount', 9,8)->default(0.00000000);
            $table->string('bitcoin_currency')->default('BTC');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
