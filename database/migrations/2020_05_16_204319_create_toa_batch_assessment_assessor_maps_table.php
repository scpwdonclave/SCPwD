<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToaBatchAssessmentAssessorMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toa_batch_assessment_assessor_maps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bt_id');
            $table->unsignedBigInteger('as_id');
            $table->string('doc_no');
            // $table->string('as_name');
            $table->string('qr_id')->nullable();
            $table->string('bt_toa_id')->nullable();
            $table->string('percentage')->nullable();
            $table->string('grade')->nullable();
            $table->string('digital_key')->nullable();
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
        Schema::dropIfExists('toa_batch_assessment_assessor_maps');
    }
}
