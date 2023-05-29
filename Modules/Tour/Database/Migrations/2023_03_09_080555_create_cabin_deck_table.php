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
        Schema::create('tour_cabin_decks', function (Blueprint $table) {
            $table->id();
            $table->uuid("tour_cabin_deck_uuid")->index("uidx_tour_cabin_deck-uuid")->unique("uidx_tour_cabin_deck-uuid");
            $table->string("title")->nullable();
            $table->text("description")->nullable();
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
        Schema::dropIfExists('cabin_deck');
    }
};
