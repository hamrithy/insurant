<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('reference_no')->nullable();
            $table->integer('branch_id');
            $table->integer('cust_id');
            $table->integer('cust_type');
            $table->string('currency');            
            $table->decimal('amount');
            $table->decimal('administration_fee');
            $table->decimal('insurance_fee');
            $table->decimal('cash_out');
            $table->integer('repayment_method');
            $table->integer('payment_times');
            $table->integer('interest_method');
            $table->decimal('interest_rate');
            $table->timestamp('disbursed_date');
            $table->decimal('penalty_paid_late');
            $table->decimal('penalty_paid_off');
            $table->integer('staff_id');
            $table->text('memo')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::drop('loans');
    }
}
