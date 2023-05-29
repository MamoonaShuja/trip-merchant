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
        Schema::create('tour_reviews', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("tour_review_uuid")->index("idx_tour_review-uuid")->unique("uidx_tour_review-uuid");
            $table->string("rating_accommodation");
            $table->string("rating_overall");
            $table->string("rating_meals");
            $table->string("rating_transportation");
            $table->string("name");
            $table->string("email");
            $table->text("comment");
            $table->foreignId("tour_id");
            $table->foreign('tour_id')->references('id')->on('tours');
            $table->foreignId("member_id")->nullable();
            $table->foreign('member_id')->references('id')->on('users');
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
        Schema::dropIfExists('tour_reviews');
    }
};
