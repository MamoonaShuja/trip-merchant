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
        Schema::create('schedule_demos', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->uuid('demo_uuid')->index("demo_uuid");
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('type');
            $table->text('message');
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
        Schema::dropIfExists('schedule_demos');
    }
};
