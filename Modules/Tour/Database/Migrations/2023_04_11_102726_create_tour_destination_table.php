<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_destination', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id');
            $table->foreignId('tour_id');
            $table->foreign('tour_id')->references('id')->on('tours');
            $table->foreign('destination_id')->references('id')->on('destinations');
            $table->unique(['destination_id' , 'tour_id']);
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
        Schema::dropIfExists('tour_destination');
    }
};
