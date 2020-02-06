<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReassessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reassessments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bt_id');
            $table->unsignedBigInteger('aa_id')->nullable();
            $table->unsignedBigInteger('as_id')->nullable();
            $table->unsignedBigInteger('tp_id');
            $table->unsignedBigInteger('tc_id');
            $table->boolean('verified')->nullable()->comment="null: Not Verified, 1: Verified, 0: Rejected";
            $table->string('assessment')->nullable();
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
        Schema::dropIfExists('reassessments');
    }
}
