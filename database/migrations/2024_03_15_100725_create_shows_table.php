<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('description');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('video_url')->nullable();
            $table->string('promo_url')->nullable();
            $table->integer('team_1_id');
            $table->integer('team_2_id');
            $table->string('banner')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('live_at')->nullable();
            $table->timestamp('stop_at')->nullable();
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
        Schema::dropIfExists('shows');
    }
}
