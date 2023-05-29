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
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("city_uuid")->index("uidx_city-uuid")->unique("uidx_city-uuid");
            $table->string("slug")->index("idx_city-slug")->unique("uidx_city-slug");
            $table->string("name");
            $table->foreignId("country_id");
            $table->foreign('country_id')->references('id')->on('countries');
            $table->softDeletes();
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
        Schema::dropIfExists('cities');
    }
};
