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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("subscribers_uuid")->index("idx_subscriber-uuid")->unique("uidx_subscriber-uuid");
            $table->string("email")->index("idx_subscriber-email")->unique("uidx_subscriber-email");
            $table->foreignId("organization_id");
            $table->foreign('organization_id')->references('id')->on('users');
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
        Schema::dropIfExists('subscriber');
    }
};
