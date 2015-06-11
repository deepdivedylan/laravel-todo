<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
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
        Schema::drop('users');
    }

	/**
	 * DEFINE RELATIONSHIPS
	 * each user has one profile
	 **/
	public function profile() {
		return $this->hasOne('Profile');
	}

	/**
	 * each user has many todos
	 **/
	public function todos() {
		return $this->hasMany('Todo');
	}
}
