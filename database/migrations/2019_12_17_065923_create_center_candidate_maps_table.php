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
            $table->string('d_cert')->nullable()->comment = 'Disability Certificate';
            $table->string('m_status')->default('Unmarried')->comment = 'Marital Status';
            $table->string('service')->comment = 'Ex Serviced or Not';

            $table->text('address');
            $table->string('state_district');
            $table->string('education');
            $table->string('g_name')->comment = 'Guardian Name';
            $table->string('g_type')->comment = 'Guardian Type';
            $table->boolean('passed')->nullable();
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
