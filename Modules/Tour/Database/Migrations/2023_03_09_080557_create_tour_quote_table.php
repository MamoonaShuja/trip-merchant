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
        Schema::create('tour_quotes', function (Blueprint $table) {
            $table->id();
            $table->uuid("tour_quote_uuid")->index("uidx_tour_quotes-uuid")->unique("uidx_tour_quotes-uuid");
            $table->string("passenger_number")->nullable();
            $table->string("date")->nullable();
            $table->text("description")->nullable();
            $table->boolean("status")->default(0);
            $table->string("note")->nullable();
            $table->foreignId("user_id");
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId("city_id");
            $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('tour_quote');
    }
};
