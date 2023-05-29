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
        Schema::create('tour_essential_infos', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("tour_essential_info_uuid")->index("uidx_tour_essential_info-uuid")->unique("uidx_tour_essential_info-uuid");
            $table->string("title")->nullable();
            $table->text("description")->nullable();
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
        Schema::dropIfExists('tour_essential_infos');
    }
};
