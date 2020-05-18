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
            $table->unsignedBigInteger('aa_id');
            $table->boolean('doc_type')->default(1)->comment='1:Aadhaar 0:Voter';
            $table->string('doc_no');

            $table->string('salutation');
            $table->string('name');
            $table->string('email');
            $table->string('contact');
            $table->string('gender');
            $table->string('dob');
            $table->boolean('is_pwd');
            $table->string('d_type')->nullable();
            $table->string('landline');
            
            $table->string('g_name');
            $table->string('g_type');

            $table->string('address');
            $table->string('pin');
            $table->string('city');
            $table->string('state_district');
            $table->string('domain_cert_no')->nullable();
            $table->string('domain_ssc_doc')->nullable();


            $table->string('qualification');
            $table->string('industry_exp');
            $table->string('assessing_exp');

            $table->string('curr_aa_name');
            $table->string('doa_curr_aa');

            $table->string('job_type')->comment='Fulltime:Freelancer';
            $table->string('state_loc_employment');
            
            $table->string('sector');
            $table->string('sub_sector');
            $table->string('domain_job');
            
            $table->string('domain_job_code');
            $table->string('nsqf');
            $table->string('no_batch_assessed');
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
