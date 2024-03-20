a<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_content_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_english')->nullable();
            $table->string('title_hebrew')->nullable();
            $table->string('description_english')->nullable();
            $table->string('description_hebrew')->nullable();
            $table->string('error_english')->nullable();
            $table->string('error_hebrew')->nullable();
            $table->string('alert_english')->nullable();
            $table->string('alert_hebrew')->nullable();
            $table->string('explantion_popup1_title_english')->nullable();
            $table->string('explantion_popup1_title_hebrew')->nullable();
            $table->string('explantion_popup1_description_english')->nullable();
            $table->string('explantion_popup1_description_hebrew')->nullable();
            $table->string('explantion_popup2_title_english')->nullable();
            $table->string('explantion_popup2_title_hebrew')->nullable();
            $table->string('explantion_popup2_description_hebrew')->nullable();
            $table->string('explantion_popup2_description_english')->nullable();
            $table->string('camera_english')->nullable();
            $table->string('camera_hebrew')->nullable();
            $table->string('gallery_english')->nullable();
            $table->string('gallery_hebrew')->nullable();
            $table->string('app_content_id')->nullable();
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
        Schema::dropIfExists('app_content_fields');
    }
}
