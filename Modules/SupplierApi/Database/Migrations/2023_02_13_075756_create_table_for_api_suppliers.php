<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SupplierApi\Enum\SupplierResponse;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string("name")->index("uidx_name")->unique("uidx_name")->comment("Name for the supplier");
            $table->string("main_url")->index("uidx_main-url")->unique("uidx_main-url")->comment("Url for getting all record from api");
            $table->string("single_record_url")->index("uidx_single-record-url")->unique("uidx_single-record-url")->comment("Url for getting single record from api. and in url %s% will be replaces by unique_id_key value");
            $table->boolean("is_authorization_needed")->default(0)->comment("To verify if authorization is needed");
            $table->string("api_key")->index("uidx_api-key")->unique("uidx_api-key")->nullable()->comment("If any authorization is needed this would be api key");
            $table->string("api_secret")->index("uidx_api-secret")->unique("uidx_api-secret")->nullable()->comment("If any authorization is needed this would be api secret key");
            $table->string("unique_id_key")->comment("It would be Id or Code on basis of which single url will be fetched");
            $table->string("class_name")->unique()->comment("This would be the class Name whose object would be created while parsing data");
            $table->enum("return_type" , [
                SupplierResponse::JSON->value,
                SupplierResponse::XML->value,
            ])->comment("return type of data either it is json or xml");
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
        Schema::dropIfExists('api_suppliers');
    }
};
