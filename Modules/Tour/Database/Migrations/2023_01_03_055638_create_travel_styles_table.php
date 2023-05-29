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
        Schema::create('travel_styles', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("travel_style_uuid")->index("uidx-travel_style-uuid")->unique("uidx-travel_style-uuid");
            $table->string('name');
            $table->boolean("is_group");
            $table->string('slug');
            $table->text('content')->nullable();
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
        Schema::dropIfExists('travel_styles');
    }
};
