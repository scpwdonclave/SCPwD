<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainerNeutralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_neutrals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('t_id');
            $table->unsignedBigInteger('tp_id');
            $table->unsignedBigInteger('tp_job_id');
            $table->string('trainer_id');
            $table->string('name');
            $table->string('doc_number');
            $table->string('doc_type');
            $table->string('doc_file');
            $table->string('mobile');
            $table->string('email');
            $table->string('ssc_doc');
            $table->string('ssc_issued');
            $table->string('ssc_valid');
            $table->string('scpwd_doc');
            $table->string('scpwd_issued');
            $table->string('scpwd_valid');
            $table->string('resume');
            $table->string('other_doc')->nullable();

            $table->boolean('status')->default(0);
            $table->boolean('ind_status')->default(0);
            $table->boolean('attached')->default(0)->comment = 'Linked to TP or Not';
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
        Schema::dropIfExists('trainer_neutrals');
    }
}
