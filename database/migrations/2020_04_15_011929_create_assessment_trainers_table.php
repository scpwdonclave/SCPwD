<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentTrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_trainers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tot_id');
            $table->string('qr_id');
            $table->string('aadhaar');
            $table->string('name');
            $table->string('email');
            $table->string('contact');
            $table->string('gender');
            $table->string('dob');
            $table->string('sip_tr_id');
            $table->string('sip_tc_id');
            $table->string('tc_name');
            $table->string('tc_address');
            $table->string('tp_name');
            $table->string('utr_no');
            $table->string('dop')->comment='Date of Payment';
            $table->string('scheme');
            $table->boolean('has_ssc');
            $table->string('ssc_certno')->nullable();
            $table->boolean('details_on_inspc');
            $table->boolean('has_disability');
            $table->string('d_type')->nullable();
            $table->string('cert_module');
            $table->string('cert_disabilities');
            $table->string('high_quali');
            $table->string('industry_exp');
            $table->string('training_exp');
            $table->string('domain_job');
            $table->string('domain_job_code');
            $table->string('g_type');
            $table->string('g_name');
            $table->string('address');
            $table->string('pin');
            $table->string('city');
            $table->string('state');
            $table->string('district');
            $table->string('batch_start');
            $table->string('batch_end');
            $table->string('percentage');
            $table->string('grade');
            $table->string('validity')->nullable();
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
        Schema::dropIfExists('assessment_trainers');
    }
}
