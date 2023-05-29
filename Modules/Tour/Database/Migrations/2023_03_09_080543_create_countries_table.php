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
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("country_uuid")->index("uidx_country-uuid")->unique("uidx_country-uuid");
            $table->string('name')->unique();
            $table->string('slug');
            $table->text('content')->nullable();
            $table->foreignId("destination_id");
            $table->foreign('destination_id')->references('id')->on('destinations');
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
        Schema::dropIfExists('countries');
    }
};
