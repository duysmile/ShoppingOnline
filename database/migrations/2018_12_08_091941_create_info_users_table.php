<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('address');
            $table->string('tel_no', 15);
            $table->boolean('gender'); //true: Female, false: Male
            $table->date('birth_date');
            $table->softDeletes();

            $table->primary('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('info_users');
    }
}
