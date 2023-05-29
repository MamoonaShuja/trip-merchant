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
        Schema::create('organization_tour', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("organization_id");
            $table->unsignedBigInteger("tour_id");
            $table->unique(['organization_id', 'tour_id']);
            $table->foreign('organization_id')->references('id')->on('users');
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
        Schema::dropIfExists('organization_tour');
    }
};
