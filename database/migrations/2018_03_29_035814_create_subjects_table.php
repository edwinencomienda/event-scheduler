<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->longText('description')->nullalbe();
            $table->time('time_start');
            $table->time('time_end');
            $table->string('day_code');
            $table->string('room')->nullable();
            $table->boolean('is_lab');
            $table->float('units');
            $table->unsignedInteger('section_id')->index();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->unsignedInteger('instructor_id')->index();
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('subjects');
    }
}
