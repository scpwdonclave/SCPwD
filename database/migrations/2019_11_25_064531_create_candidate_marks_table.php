<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bt_assessment_id');
            $table->unsignedBigInteger('candidate_id');
            $table->string('mark')->nullable(); 
            $table->string('attendence');
            $table->integer('passed')->nullable();
            $table->string('certi_no')->nullable();

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
        Schema::dropIfExists('candidate_marks');
    }
}
