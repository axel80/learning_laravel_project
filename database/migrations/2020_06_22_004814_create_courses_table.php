<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('level_id');
            $table->string('name');
            $table->string('description');
            $table->string('slug');
            $table->string('picture')->nullable();
            $table->enum('status', [
                \App\Course::PUBLISHED,
                \App\Course::PENDING,
                \App\Course::REJECTED,
            ])->default(\App\Course::PENDING);
            $table->boolean('previous_approved')->nullable(false);
            $table->boolean('previous_rejected')->nullable(false);
            $table->timestamps();
            $table->softDeletes();


            // Fk's
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('level_id')->references('id')->on('levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
