<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invited', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inviter_id')->unsigned()->nullable();
            $table->foreign('inviter_id')->references('id')->on('users');
            $table->integer('invite_id')->unsigned()->nullable();
            $table->foreign('invite_id')->references('id')->on('users');
            $table->string('email');
            $table->string('first_name');
            $table->integer('role');
            $table->string('code')->nullable();
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
        Schema::dropIfExists('invited');
    }
}
