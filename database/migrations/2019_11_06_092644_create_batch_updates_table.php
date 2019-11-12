<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_updates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bt_id');
            $table->unsignedBigInteger('tp_id');
            $table->unsignedBigInteger('tr_id');
            $table->unsignedBigInteger('new_tr_id')->nullable();
            $table->string('new_tr_start')->nullable();
            $table->string('end_date')->nullable();
            $table->string('assessment')->nullable();
            $table->boolean('action')->default(0)->comment = 'Admin took action';
            $table->boolean('approved')->nullable()->comment = 'Update Accept Reject';
            $table->text('reason')->nullable()->comment = 'Reason of Rejection';
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
        Schema::dropIfExists('batch_updates');
    }
}
