<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reporter_user_id');
            $table->integer('reportee_user_id');
            $table->enum('type', ['photo', 'post', 'comment']);
            $table->string('reason');
            $table->enum('status', ['accepted', 'pending', 'declined'])->default('pending');
            $table->string('action_taken');
            $table->integer('admin_user_id');
            $table->timestamp('action_timestamp');
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
        Schema::dropIfExists('reports');
    }
}
