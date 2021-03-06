<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['user', 'support', 'admin'])->default('user');
            $table->string('profile_img')->nullable();
            $table->string('banner_img')->nullable();
            $table->string('bio')->nullable();
            $table->enum('verified', ['yes', 'no'])->default('no');
            $table->enum('suspended', ['yes', 'no'])->default('no');
            $table->enum('activity_visibility', ['public', 'friends', 'me'])->default('public');
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
        Schema::dropIfExists('users');
    }
}
