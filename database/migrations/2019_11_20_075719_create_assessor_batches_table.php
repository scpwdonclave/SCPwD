<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessorBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessor_batches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('as_id');
            $table->unsignedBigInteger('bt_id');
            $table->unsignedBigInteger('aa_bt_id');
            $table->unsignedBigInteger('reass_id')->nullable();
            
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
        Schema::dropIfExists('assessor_batches');
    }
}
