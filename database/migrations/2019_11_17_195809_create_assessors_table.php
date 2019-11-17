<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('as_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            
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
        Schema::drop('assessors');
    }
}
