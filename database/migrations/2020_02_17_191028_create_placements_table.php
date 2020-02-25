<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tp_id');
            $table->unsignedBigInteger('tc_id');
            $table->unsignedBigInteger('ccd_id');
            $table->string('org_name');
            $table->string('employment_date');
            $table->string('emp_type');
            $table->text('org_address');
            $table->string('org_state_dist');
            $table->string('emp_spoc_name')->nullable();
            $table->string('emp_spoc_mobile')->nullable();
            $table->string('emp_spoc_email')->nullable();
            $table->string('offer_letter');
            $table->string('appointment_letter');
            $table->string('payslip1')->nullable();
            $table->string('payslip2')->nullable();
            $table->string('payslip3')->nullable();
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
        Schema::dropIfExists('placements');
    }
}
