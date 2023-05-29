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
        Schema::create('tours', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("tour_uuid")->index("uidx_tour-uuid")->unique("uidx_tour-uuid");
            $table->string("title");
            $table->string("members_rate")->nullable();
            $table->string("discount_members_rate")->nullable();
            $table->string("members_benefit")->nullable();
            $table->string("total_days")->nullable();
            $table->string("total_nights")->nullable();
            $table->text("terms_and_conditions")->nullable();
            $table->text("overview")->nullable();
            $table->text("highlights")->nullable(); //not confirmed;
            $table->text("included")->nullable();
            $table->text("deposit_and_payments")->nullable(); //not confirmed
            $table->text("not_included")->nullable();
            $table->string("total_meals")->nullable();
            $table->text("activity_level")->nullable();
            $table->string("passenger_limit")->nullable();
            $table->text("upgrades")->nullable(); //no confirmed
            $table->string("age_range")->nullable();
            $table->boolean("is_visible");
            $table->string("slug")->index("idx_tour-slug")->unique("uidx_tour-slug");
            $table->foreignId("supplier_id")->nullable();
            $table->foreign('supplier_id')->references('id')->on('users');
            $table->foreignId("travel_style_id")->nullable();
            $table->foreign('travel_style_id')->references('id')->on('travel_styles');

//            APi Data
            $table->foreignId("api_supplier_id")->nullable();
            $table->foreign('api_supplier_id')->references('id')->on('api_suppliers');
            $table->foreignId("api_tour_id")->nullable();
            $table->foreign('api_tour_id')->references('id')->on('api_tour_ids');

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
        Schema::dropIfExists('tours');
    }
};
