<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schemes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('scheme');
            $table->unsignedBigInteger('dept_id');
            $table->string('dummy')->nullable()->comment='Dummy Certificate Format';
            $table->string('cert_name')->nullable()->comment='NULL: not verified yet by onclave';
            $table->string('cert_format');
            $table->boolean('fin_yr')->default(0);
            $table->string('year');
            $table->boolean('invoice_on')->comment='1: assigned, 0: appeared';
            $table->boolean('disability')->comment='1: multi type, 0: single type';
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('schemes');
    }
}
