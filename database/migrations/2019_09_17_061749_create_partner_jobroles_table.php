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
            $table->unsignedBigInteger('tp_id');
            $table->unsignedBigInteger('scheme_id');
            $table->unsignedBigInteger('sector_id');
            $table->unsignedBigInteger('jobrole_id');
            $table->string('target');
            $table->string('assigned')->default(0);
            $table->boolean('status')->default(1);
            $table->boolean('direct_action')->default(0)->comment='status_flag for changes here';
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
