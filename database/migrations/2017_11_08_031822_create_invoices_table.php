<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('totalPrice');
            $table->string('cutoffPrice')->nullable();
            $table->string('payPrice')->nullable();
            $table->string('paymentInfo')->nullable();
            $table->string('invoiceId')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->enum('status',['saved','wait','paid','reject'])->default('saved');
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
        Schema::dropIfExists('invoices');
    }
}
