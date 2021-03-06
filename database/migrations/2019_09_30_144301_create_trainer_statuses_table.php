<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainerStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prv_id');
            $table->string('trainer_id');
            $table->unsignedBigInteger('tp_id'); 
            $table->string('name');
            $table->string('doc_no');
            $table->string('doc_type');
            $table->string('doc_file');
            $table->string('mobile');
            $table->string('email');
            $table->string('scpwd_no')->nullable();
            $table->string('scpwd_doc')->nullable();
            $table->string('scpwd_issued')->nullable();
            $table->string('scpwd_valid')->nullable();

            $table->string('qualification');
            $table->string('sector_exp');
            $table->string('teaching_exp');
            $table->string('qualification_doc');
            $table->string('ssc_no')->nullable();
            $table->string('ssc_doc')->nullable();
            $table->string('ssc_issued')->nullable();
            $table->string('ssc_valid')->nullable();

            $table->string('resume')->nullable();
            $table->string('other_doc')->nullable();

            $table->string('f_month')->nullable();
            $table->string('f_year')->nullable();

            $table->string('dlink_reason')->nullable();

            $table->boolean('status')->default(1);
            $table->boolean('attached')->default(0)->comment = 'Trainer Attached Ditached State';
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
        Schema::dropIfExists('trainer_statuses');
    }
}
