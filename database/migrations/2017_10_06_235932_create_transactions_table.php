<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id');
            $table->integer('user_id');
            $table->integer('seller_id');
            $table->string('totalPrice');
            $table->string('cutoffPrice')->nullable();
            $table->string('receiptNumber')->nullable();
            $table->boolean('feedback')->nullable();
            $table->enum('status',['saved','wait','paid','reject','sent','done'])->default('saved');
            $table->boolean('invoiceReject')->default(false);
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('sent')->nullable();
            $table->timestamp('done_at')->nullable();
            $table->timestamps();
        });

        Schema::create('item_transaction', function (Blueprint $table) {
            $table->integer('item_id');
            $table->integer('transaction_id');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('item_transaction');
    }
}
