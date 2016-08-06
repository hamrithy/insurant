<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_type_base_id');
            $table->integer('default_case_flow_type_id');
            $table->integer('allow_to_change_default_cash_flow_type');
            $table->string('code');
            $table->string('name');
            $table->string('key_name');
            $table->text('memo');
            $table->integer('is_system_value');
            $table->integer('stratus_id');
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
        Schema::drop('account_types');
    }
}
