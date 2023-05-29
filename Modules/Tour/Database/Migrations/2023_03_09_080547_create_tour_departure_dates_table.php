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
        Schema::create('tour_departure_dates', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("tour_departure_uuid")->index("uidx_departure-uuid")->unique("uidx_departure-uuid");
            $table->string("year")->nullable();
            $table->date("start_date")->nullable();
            $table->date("end_date")->nullable();
            $table->string("availability")->nullable();
            $table->string("price")->nullable();
            $table->foreignId("tour_id")->nullable();
            $table->foreign('tour_id')->references('id')->on('tours');
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
        Schema::dropIfExists('tour_departure_dates');
    }
};
