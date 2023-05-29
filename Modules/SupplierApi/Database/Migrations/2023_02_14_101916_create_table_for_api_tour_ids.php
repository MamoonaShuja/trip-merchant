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
        Schema::create('api_tour_ids', function (Blueprint $table) {
            $table->id();
            $table->string("unique_key")->comment("This is any unique id value for fetching single result");
            $table->boolean("fetched")->comment("This is the column to check if this specific record has already been fetched or not");
            $table->foreignId("supplier_id")->comment("Foreign key for api suppliers");
            $table->foreign("supplier_id")->references("id")->on("api_suppliers");
            $table->unique(["unique_key" , "supplier_id"]);
            $table->dateTime("last_scrapped_at")->nullable()->comment("Check last scrapped date and time");
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
        Schema::dropIfExists('api_tour_ids');
    }
};
