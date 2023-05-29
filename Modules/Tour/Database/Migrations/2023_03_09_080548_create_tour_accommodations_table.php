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
        Schema::create('tour_accommodations', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("tour_accommodation_uuid")->index("uidx_accommodation-uuid")->unique("uidx_accommodation-uuid");
            $table->string("hotel_name")->nullable();
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
        Schema::dropIfExists('tour_accommodations');
    }
};
