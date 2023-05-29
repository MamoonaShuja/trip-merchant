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
        Schema::create('tour_locations', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("tour_location_uuid")->index("idx_tour_locations-uuid")->unique("uidx_tour_locations-uuid");
            $table->string("lat")->nullable();
            $table->string("long")->nullable();
            $table->boolean("is_image")->default(0);
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
        Schema::dropIfExists('tour_locations');
    }
};
