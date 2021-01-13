<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobseekerGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobseeker_gallery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jobseeker_id')->unsigned();
            $table->foreign('jobseeker_id')->references('id')->on('jobseekers');
            $table->string('image');
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
        Schema::dropIfExists('jobseeker_gallery');
    }
}
