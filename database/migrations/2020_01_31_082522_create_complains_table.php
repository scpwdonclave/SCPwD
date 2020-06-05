<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token_id');
            $table->string('username');
            $table->string('userid');
            $table->unsignedBigInteger('rel_id');
            $table->string('rel_with');
            $table->string('subject');
            $table->string('issue');
            $table->text('description');
            $table->string('stage');
            $table->string('closure_comment')->nullable();
            $table->string('attachment')->nullable();
            $table->date('process_at')->nullable();
            $table->date('closed_at')->nullable();
            $table->boolean('assign_onclave')->default(0);
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
        Schema::dropIfExists('complains');
    }
}
