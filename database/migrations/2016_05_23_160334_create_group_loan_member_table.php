<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupLoanMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_loan_members', function (Blueprint $table) {
            $table->integer('group_id')->unsigned();
            $table->integer('member_id')->unsigned();
            $table->integer('member_type');
            $table->string('relation')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();

            $table->primary(['group_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_loan_members');
    }
}
