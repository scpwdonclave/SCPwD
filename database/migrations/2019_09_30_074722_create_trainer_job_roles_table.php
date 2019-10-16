<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainerJobRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_job_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tr_id');
            $table->unsignedBigInteger('scheme_id');
            $table->unsignedBigInteger('sector_id');
            $table->string('ssc_no');
            $table->string('ssc_doc');
            $table->string('ssc_issued');
            $table->string('ssc_valid');
            $table->unsignedBigInteger('jobrole_id');
            $table->boolean('status')->default(1);
            $table->boolean('scheme_status')->default(1);
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
        Schema::dropIfExists('trainer_job_roles');
    }
}
