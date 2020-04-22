<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentAssessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_assessors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('gender');
            $table->string('dob');
            $table->boolean('is_pwd');
            $table->string('d_type')->nullable();
            $table->string('doc_no');
            $table->string('education');
            $table->string('industry_exp');
            $table->string('assessing_exp');
            $table->string('contact');
            $table->string('landline');
            $table->string('email');
            $table->string('g_type');
            $table->string('g_name');
            $table->string('aa_name');
            $table->string('job_type');
            $table->string('doa_curr_aa');
            $table->string('state_loc_employment');
            $table->string('sector');
            $table->string('sub_sector');
            $table->string('domain_job');
            $table->string('nsqf');
            $table->string('batch_assessed');
            $table->string('address');
            $table->string('pin');
            $table->string('city');
            $table->string('state');
            $table->string('district');
            $table->boolean('domain_approved');
            $table->string('domain_ssc_doc')->nullable();
            $table->string('domain_cert_no')->nullable();
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
        Schema::dropIfExists('assessment_assessors');
    }
}
