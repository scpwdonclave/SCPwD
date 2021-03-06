<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->unsignedBigInteger('tc_id');
            // $table->unsignedBigInteger('tc_job_id');
            $table->string('cd_id')->unique();

            $table->string('name');
            $table->string('gender');
            $table->string('contact');
            $table->string('email')->nullable();
            // $table->string('d_type')->comment = 'Disability Type';
            // $table->string('d_cert')->nullable()->comment = 'Disability Certificate';
            $table->string('dob');
            // $table->string('m_status')->default('Unmarried')->comment = 'Marital Status';
            $table->boolean('doc_type')->default(1)->comment='1: Aadhaar, 0: Voter';
            $table->string('doc_no')->unique();
            $table->string('doc_file')->comment = 'File URL';
            $table->string('category');
            // $table->string('service')->comment = 'Ex Serviced or Not';

            // $table->text('address');
            // $table->string('state_district');
            // $table->string('education');
            // $table->string('g_name')->comment = 'Guardian Name';
            // $table->string('g_type')->comment = 'Guardian Type';
            $table->boolean('status')->default(1);
            // $table->boolean('passed')->nullable();
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
        Schema::dropIfExists('candidates');
    }
}
