<?php

namespace Modules\SupplierApi\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SupplierApi\Entities\ApiSupplier;
use Modules\SupplierApi\Enum\SupplierResponse;
class SupplierApi extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            [
             "name" => "Collette (Guided Tour)",
             "main_url" => "https://reservations.gocollette.com/api/content/package/tours",
             "single_record_url" => "https://reservations.gocollette.com/api/content/package/tour/%s/",
             "is_authorization_needed" => "1",
             "api_key" => "c3fd2f4d-5975-452e-95e0-a478a3325a01",
             "api_secret" => "a8c3479d-f46a-470b-9315-4c3cfe923b01",
             "unique_id_key" => "TourId",
             "return_type" => SupplierResponse::JSON->value,
             "class_name" => "Modules\SupplierApi\SingleRecordParsing\Collette",
            ]
            ,
            [
             "name" => "Exodus Travels (Adventure and Active Travel)",
             "main_url" => "https://www.exodus.co.uk/api/v1/trip/xml/holidays",
             "single_record_url" => "https://www.exodus.co.uk/api/v4/trip/xml/%s/",
             "is_authorization_needed" => "0",
             "api_key" => null,
             "api_secret" => null,
             "unique_id_key" => "code",
             "return_type" => SupplierResponse::XML->value,
             "class_name" => "Modules\SupplierApi\SingleRecordParsing\Exodus",
            ]
        ];
        foreach ($suppliers as $supplier) {
            ApiSupplier::create($supplier);
        }
    }
}
