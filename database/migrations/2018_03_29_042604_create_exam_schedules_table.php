<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subject_id')->index();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->date('date');
            $table->time('time_start');
            $table->time('time_end');
            $table->unsignedInteger('proctor_id')->index();
            $table->foreign('proctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('section_id')->index()->nullable();
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
        Schema::dropIfExists('exam_schedules');
    }
}
