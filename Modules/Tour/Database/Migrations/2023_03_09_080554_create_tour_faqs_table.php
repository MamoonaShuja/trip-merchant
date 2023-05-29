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
        Schema::create('tour_faqs', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("tour_faq_uuid")->index("uidx_tour_faq-uuid")->unique("uidx_tour_faq-uuid");
            $table->string("question");
            $table->text("answer");
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
        Schema::dropIfExists('tour_faqs');
    }
};
