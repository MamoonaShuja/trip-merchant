<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Tour\Enum\Meals;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_itineraries', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("tour_itinerary_uuid")->index("idx_itinerary-uuid")->unique("uidx_itinerary-uuid");
            $table->string("day")->nullable();
            $table->string("hotel_names")->nullable();
            $table->text("description")->nullable();
            $table->string("meals")->nullable();
            $table->text("optional")->nullable();
            $table->foreignId("tour_id");
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
        Schema::dropIfExists('tour_itineraries');
    }
};
