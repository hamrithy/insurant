<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cus_code')->unique();
            $table->string('name');
            $table->string('latin_name')->nullable();
            $table->datetime('date_of_birth');
            $table->char('gender');
            $table->string('identity_no');
            $table->integer('identity_type');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('province_code');
            $table->integer('district_id');
            $table->integer('commune_id');
            $table->integer('village_id');
            $table->string('street')->nullable();
            $table->string('house_no');
            $table->string('profile_photo')->nullable();
            $table->integer('status');
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
        Schema::drop('customers');
    }
}
