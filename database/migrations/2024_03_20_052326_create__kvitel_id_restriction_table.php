<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKvitelIdRestrictionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kvitelId_restriction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('start_with_zero')->nullable();
            $table->integer('five_digit_sequence_between')->nullable();
            $table->string('same_number_repeated_four_times_or_more')->nullable();
            $table->string('starting_with_five_digit_or_more_ascending')->nullable();
            $table->string('starting_with_five_digit_or_more_descending')->nullable();
            $table->string('four_different_digits')->nullable();
            $table->integer('five_digit_sequence_between_input')->nullable();
            $table->integer('same_number_repeated_four_times_or_more_input')->nullable();
            $table->integer('starting_with_five_digit_or_more_ascending_input')->nullable();
            $table->integer('starting_with_five_digit_or_more_descending_input')->nullable();
            $table->integer('four_different_digits_input')->nullable();
            $table->string('deleted_at')->nullable();
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
        Schema::dropIfExists('kvitelId_restriction');
    }
}
