<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avtar')->nullable();
            $table->string('gender')->nullable();
            $table->integer('is_verified')->default(0);
            $table->integer('is_online')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('install_date')->nullable();
            $table->string('device_type')->nullable();
            $table->string('app_version')->nullable();
            $table->string('notification_token')->nullable();
            $table->string('email_verification_code')->nullable();

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
