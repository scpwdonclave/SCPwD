<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateReMarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_re_marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bt_reassessment_id');
            $table->unsignedBigInteger('candidate_id');
            $table->string('mark')->default(0); 
            $table->string('attendence');
            $table->integer('passed')->default(0);
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
        Schema::dropIfExists('candidate_re_marks');
    }
}
