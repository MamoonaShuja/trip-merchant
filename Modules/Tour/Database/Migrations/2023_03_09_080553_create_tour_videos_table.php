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
        Schema::create('tour_videos', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("tour_video_uuid")->index("uidx_video-uuid")->unique("uidx_video-uuid");
            $table->string("video_link")->nullable();
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
        Schema::dropIfExists('tour_videos');
    }
};
