<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpositoryJobRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expository_job_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_role_id');
            $table->unsignedBigInteger('expository_id');
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
        Schema::dropIfExists('expository_job_role');
    }
}
