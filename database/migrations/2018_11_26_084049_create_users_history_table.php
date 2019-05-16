<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_history', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned()->index()->nullable();
          $table->foreign('user_id')->references('id')->on('users');
          $table->integer('editor_id')->unsigned()->index()->nullable();
          $table->foreign('editor_id')->references('id')->on('users');
          $table->string('email')->nullable();
          $table->string('first_name')->nullable();
          $table->string('last_name')->nullable();
          $table->string('surname')->nullable();
          $table->string('organization')->nullable();
          $table->string('credit_card_number')->nullable();
          $table->string('personal_acc')->nullable();
          $table->string('correspondent_acc')->nullable();
          $table->string('bic_bank')->nullable();
          $table->string('name_bank')->nullable();
          $table->string('type')->nullable();
          $table->string('cities')->nullable();
          $table->string('telegram')->nullable();
          $table->float('commission')->nullable();
          $table->integer('role_id')->unsigned()->index()->nullable();
          $table->foreign('role_id')->references('id')->on('roles');



          $table->rememberToken();
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
        Schema::dropIfExists('users_history');
    }
}
