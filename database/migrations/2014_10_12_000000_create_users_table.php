<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('organization')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->string('personal_acc')->nullable();
            $table->string('correspondent_acc')->nullable();
            $table->string('bic_bank')->nullable();
            $table->string('name_bank')->nullable();
            $table->string('type')->nullable()->default(3);
            $table->string('cities')->nullable();
            $table->string('telegram')->nullable();
            $table->float('commission')->default(0);
            $table->string('password');
            $table->integer('role_id')->unsigned()->index()->nullable()->default(3);
            $table->foreign('role_id')->references('id')->on('roles');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
