<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAadhaarRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aadhaar_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('guard');
            $table->unsignedBigInteger('userid');
            $table->string('username');
            $table->string('stan');
            $table->string('doc_no');
            $table->string('verification_code');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aadhaar_requests');
    }
}
