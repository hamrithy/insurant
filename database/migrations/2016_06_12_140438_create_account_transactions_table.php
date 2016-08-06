<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('generate_id');
            $table->string('transaction_no');
            $table->decimal('total_debit_credit');
            $table->integer('journal_entry_id');
            $table->integer('loan_id');
            $table->integer('payment_id');
            $table->integer('write_off_loan_id');
            $table->integer('expense_id');
            $table->integer('income_id');
            $table->integer('saving_deposit_id');
            $table->integer('saving_withdraw_id');
            $table->integer('exchange_rate_id');
            $table->timestamp('transaction_date');
            $table->integer('transaction_type');
            $table->text('memo');
            $table->integer('version');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::drop('account_transactions');
    }
}
