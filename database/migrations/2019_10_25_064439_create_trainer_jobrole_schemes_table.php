<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainerJobroleSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_jobrole_schemes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tr_job_id');
            $table->unsignedBigInteger('scheme_id');
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
        Schema::dropIfExists('trainer_jobrole_schemes');
    }
}
