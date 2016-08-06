<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTracsactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transaction_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_transaction_id');
            $table->integer('chart_account_id');
            $table->integer('branch_id');
            $table->decimal('debit');
            $table->decimal('credit');
            $table->text('memo');
            $table->integer('pair_account_group');
            $table->integer('transaction_version');
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
        Schema::drop('account_transaction_detail');
    }
}
