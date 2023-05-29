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
        Schema::create('tour_accommodation_amenities', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("tour_accommodation_amenity_uuid")->index("uidx_tour_accommodation_amenity-uuid")->unique("uidx_tour_accommodation_amenity-uuid");
            $table->string("meta_key");
            $table->string("meta_value");
            $table->string("icon");
            $table->foreignId("tour_accommodation_id");
            $table->foreign('tour_accommodation_id')->references('id')->on('tour_accommodations');
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
        Schema::dropIfExists('tour_accommodation_ammenities');
    }
};
