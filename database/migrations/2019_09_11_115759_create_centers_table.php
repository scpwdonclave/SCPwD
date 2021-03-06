<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */  
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('tp_id');
            $table->string('tc_id')->unique()->nullable();
            
            $table->string('spoc_name');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('password')->nullable();

            $table->string('center_name')->nullable();
            $table->text('center_address');
            $table->text('landmark');
           

            $table->string('state_district');
            $table->string('city');
            $table->string('block');
            $table->string('parliament');
            $table->string('pin');
            $table->string('addr_proof');
            $table->string('addr_doc');

            $table->string('center_front_view')->nullable();
            $table->string('center_back_view')->nullable();
            $table->string('center_right_view')->nullable();
            $table->string('center_left_view')->nullable();
            $table->string('biometric')->nullable();
            $table->string('drinking')->nullable();
            $table->string('safety')->nullable();
            
            /* Financial Year and Month */
            $table->string('f_month')->nullable();
            $table->string('f_year')->nullable();
            /*End of Financial Year and Month */
            
            $table->boolean('status')->default(0);
            $table->boolean('verified')->default(0);
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
        Schema::drop('centers');
    }
}
