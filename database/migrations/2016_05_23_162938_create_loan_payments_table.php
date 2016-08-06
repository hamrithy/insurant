<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('loan_id')->unsigned();
            $table->string('reference_no')->nullable();
            $table->integer('receiver_id');
            $table->timestamp('payment_date');
            $table->decimal('remain_interest_amount');
            $table->decimal('due_paid_off_penalty_amount');
            $table->decimal('paid_off_penalty_amount');
            $table->decimal('oustanding_amount');
            $table->decimal('total_paid');
            $table->text('memo')->nullable();
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
        Schema::drop('loan_payments');
    }
}
