<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('underwriter_id')->unsigned()->index()->nullable();
            $table->foreign('underwriter_id')->references('id')->on('users');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('money')->nullable();
            $table->string('phone')->nullable();
            $table->string('type')->nullable();
            $table->string('total_amount')->nullable();
            $table->integer('lead_status')->unsigned()->index()->default(1);
            $table->foreign('lead_status')->references('id')->on('lead_statuses');
            $table->integer('transaction_status')->unsigned()->index()->default(1);
            $table->foreign('transaction_status')->references('id')->on('transaction_statuses');
            $table->integer('city_id')->unsigned()->index()->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('leads');
    }
}
