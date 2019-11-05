<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aa_id')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('aadhaar')->unique();
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('gender');
            $table->string('designation');
            $table->string('landline')->nullable();



            $table->string('agency_name');
            $table->string('org_type');
            $table->string('org_id');
            $table->string('sla_date');
            $table->string('sla_end_date');

            $table->string('ceo_name');
            $table->string('ceo_aadhaar')->unique();
            $table->string('ceo_email')->unique();
            $table->string('ceo_mobile')->unique();
            $table->string('ceo_gender');
            $table->string('ceo_designation');
            $table->string('ceo_landline')->nullable();
            $table->string('org_address');
            $table->string('post_office');
            $table->unsignedBigInteger('state_district');
            $table->unsignedBigInteger('parliament');
            $table->string('city');
            $table->string('sub_district');
            $table->string('pin');
            $table->string('org_landline')->nullable();
            $table->string('website')->nullable();

            $table->boolean('status')->default(1);
            $table->rememberToken();
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
        Schema::drop('agencies');
    }
}
