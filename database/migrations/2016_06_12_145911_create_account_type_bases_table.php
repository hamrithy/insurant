<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTypeBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_type_bases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->string('key_name');
            $table->integer('is_debit_increase');
            $table->text('memo');
            $table->integer('is_system_value');
            $table->integer('status_id');
            $table->integer('version');
            $table->integer('created_by');
            $table->integer('update_by');
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
        Schema::drop('account_type_bases');
    }
}
