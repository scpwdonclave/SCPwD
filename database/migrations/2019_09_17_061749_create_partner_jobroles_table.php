<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerJobrolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_jobroles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tp_id');
            $table->string('scheme_id');
            $table->string('sector_id');
            $table->string('jobrole_id');
            $table->string('target');
            $table->string('status')->default(1);
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
        Schema::dropIfExists('partner_jobroles');
    }
}
