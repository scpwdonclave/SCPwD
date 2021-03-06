<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sector_id');
            $table->string('job_role');
            $table->string('qp_code');
            $table->string('nsqf_level');
            $table->string('hours');
            $table->string('full_marks');
            $table->string('pass_marks');
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
        Schema::dropIfExists('job_roles');
    }
}
