<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerUpdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_update', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tp_id');
            $table->string('spoc_name');
            $table->string('email');
            $table->string('spoc_mobile');
            $table->boolean('action')->default(0);
            $table->boolean('approve')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('partner_update');
    }
}
