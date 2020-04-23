<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('as_id')->nullable()->unique();
            $table->unsignedBigInteger('aa_id');
            $table->string('password')->nullable();
            $table->string('name');
            $table->string('birth');
            $table->string('gender');
            $table->string('religion')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('d_type')->nullable();
            $table->string('d_certificate')->nullable(); 
            $table->string('aadhaar'); 
            $table->string('aadhaar_doc'); 
            $table->string('pan')->nullable(); 
            $table->string('pan_doc')->nullable(); 

            $table->string('mobile')->unique(); 
            $table->string('email')->unique(); 
            $table->string('photo'); 
            $table->string('applicant_cat'); 

            $table->string('address'); 
            $table->string('post_office'); 
            $table->unsignedBigInteger('state_district'); 
            $table->string('sub_district'); 
            $table->unsignedBigInteger('parliament'); 
            $table->string('city'); 
            $table->string('pin'); 

            $table->string('education')->nullable(); 
            $table->string('edu_details')->nullable(); 
            $table->string('edu_doc')->nullable(); 

            $table->string('relevant_sector')->nullable(); 
            $table->string('exp_year')->nullable(); 
            $table->string('exp_month')->nullable(); 
            $table->string('exp_dtl')->nullable(); 
            $table->string('industry_dtl')->nullable(); 
            $table->string('exp_doc')->nullable(); 
            $table->string('resume')->nullable();

            $table->string('domain_doc'); 
            $table->string('domain_certi_end_date'); 
            $table->unsignedBigInteger('sector_id'); 

            $table->string('scpwd_certi_no'); 
            $table->string('certi_date'); 
            $table->string('scpwd_doc'); 
            $table->string('certi_end_date');

            /* Financial Year and Month */
            $table->string('f_month')->nullable();
            $table->string('f_year')->nullable();
            /*End of Financial Year and Month */
            
            $table->boolean('status')->default(1); 
            $table->boolean('verified')->default(0);
            

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
        Schema::dropIfExists('assessors');
    }
}
