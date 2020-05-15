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
            // $table->string('tot_id');
            // $table->string('qr_id');
            $table->boolean('doc_type')->default(1)->comment='1:Aadhaar 0:Voter';
            $table->string('doc_no');
            $table->string('salutation');
            $table->string('name');
            $table->string('email');
            $table->string('contact');
            $table->string('gender');
            $table->boolean('trainer_category')->default(0)->comment='1: master 0: trainer';
            $table->string('dob');
            $table->string('sip_tr_id');
            $table->string('sip_tc_id')->nullable();
            $table->string('tc_name')->nullable();
            $table->string('tc_address')->nullable();
            $table->string('tp_name');
            $table->string('utr_no');
            $table->string('dop')->comment='Date of Payment';
            $table->string('scheme')->nullable();
            $table->boolean('has_ssc')->nullable();
            $table->string('ssc_certno')->nullable();
            $table->boolean('details_on_inspc')->nullable();
            $table->boolean('has_disability');
            $table->string('d_type')->nullable();
            // $table->string('cert_module')->default('Disability Orientation & Sensitization');
            // $table->string('cert_disabilities')->default('Hearing Impairment, Blindness, Low Vision and Locomotor Disabilities');
            $table->string('high_quali');
            $table->string('industry_exp');
            $table->string('training_exp');
            $table->string('domain_job')->nullable();
            $table->string('domain_job_code')->nullable();
            $table->string('g_type');
            $table->string('g_name');
            $table->string('address');
            $table->string('pin');
            $table->string('city');
            $table->string('state_district');
            // $table->string('batch_start');
            // $table->string('batch_end');
            // $table->string('percentage');
            // $table->string('grade');
            // $table->string('validity')->nullable();
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
