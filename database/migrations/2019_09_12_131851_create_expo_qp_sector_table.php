<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpoQpSectorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expo_qp_sector', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sector_id');
            $table->unsignedBigInteger('qp_id');
            $table->unsignedBigInteger('expo_id');
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
        Schema::dropIfExists('expo_qp_sector');
    }
}
