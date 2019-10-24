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
            $table->unsignedBigInteger('jobrole_id');
            $table->string('qualification');
            $table->string('qualification_doc');
            $table->string('ssc_no')->nullable();
            $table->string('ssc_doc')->nullable();
            $table->string('ssc_issued')->nullable();
            $table->string('ssc_valid')->nullable();
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
