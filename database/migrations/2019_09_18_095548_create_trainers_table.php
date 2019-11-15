<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tp_id');
            $table->string('trainer_id')->unique()->nullable();
            $table->string('name');
            $table->string('doc_no')->unique();
            $table->string('doc_type');
            $table->string('doc_file');
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->string('scpwd_no')->nullable();
            $table->string('scpwd_doc')->nullable();
            $table->string('scpwd_issued')->nullable();
            $table->string('scpwd_valid')->nullable();

            $table->string('qualification');
            $table->string('qualification_doc');
            $table->string('ssc_no')->nullable();
            $table->string('ssc_doc')->nullable();
            $table->string('ssc_issued')->nullable();
            $table->string('ssc_valid')->nullable();

            $table->string('resume')->nullable();
            $table->string('other_doc')->nullable();

            $table->boolean('status')->default(0);
            $table->boolean('reassign')->default(0);
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
        Schema::dropIfExists('trainers');
    }
}
