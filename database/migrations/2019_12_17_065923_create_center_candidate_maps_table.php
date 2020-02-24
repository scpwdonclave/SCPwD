<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCenterCandidateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('center_candidate_maps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tc_id');
            $table->unsignedBigInteger('tc_job_id');
            $table->unsignedBigInteger('cd_id');

            $table->string('d_type')->comment = 'Disability Type';
            $table->string('d_cert')->comment = 'Disability Certificate';
            $table->string('m_status')->default('Unmarried')->comment = 'Marital Status';
            $table->string('service')->comment = 'Ex Serviced or Not';

            $table->text('address');
            $table->string('state_district');
            $table->string('education');
            $table->string('g_name')->comment = 'Guardian Name';
            $table->string('g_type')->comment = 'Guardian Type';
            /* Financial Year and Month */
            $table->string('f_month');
            $table->string('f_year');
            /*End of Financial Year and Month */
            $table->boolean('passed')->nullable()->comment = 'null:not applicable for exm|0:Failed|1:Passed|2:Absent';
            $table->string('certi_no')->nullable();
            $table->string('digital_key')->nullable();
            $table->string('assessment_certi_issued_on')->nullable()->comment = 'Final Assessment Date & Cert On';
            $table->boolean('reassessed')->nullable()->comment = '0: Released, 1: Holded for Re Assessment';
            $table->boolean('dropout')->default(0)->comment = '0: Present, 1: Dropped out';
            $table->timestamp('dropout_at')->nullable();
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
        Schema::dropIfExists('center_candidate_maps');
    }
}
