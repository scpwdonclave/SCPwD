<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_assessments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bt_id');
            $table->string('attendence_sheet');
            $table->string('mark_sheet');
            $table->boolean('aa_verified')->default(0)->comment = '0:pending,1:Approved,2:Reject';
            $table->boolean('admin_verified')->default(0)->comment = '0:pending,1:Approved,2:Reject';
            $table->boolean('sup_admin_verified')->default(0)->comment = '0:pending,1:Approved,2:Reject';
            $table->string('reject_note')->nullable();
            $table->boolean('recheck')->default(0)->comment = '0:Not recheck,1:checking done';
            $table->boolean('admin_cert_rel')->default(0)->comment = '1:Released,0:Not release';
            $table->boolean('supadmin_cert_rel')->default(0)->comment = '1:Released,0:Not release';


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
        Schema::dropIfExists('batch_assessments');
    }
}
