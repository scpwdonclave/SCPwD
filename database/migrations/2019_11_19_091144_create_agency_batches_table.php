<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgencyBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_batches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('aa_id');
            $table->unsignedBigInteger('bt_id');
            $table->boolean('aa_verified')->default(0);

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
        Schema::dropIfExists('agency_batches');
    }
}
