<?php
namespace Modules\SupplierApi\Contracts\Services;

use Modules\Tour\Entities\TravelStyle;

interface ValidatingForeignKeyContract
{
    /**
     * @return mixed
     */
    public function validateDestination(string $strDestination):string;
    public function validateCountry(string $strDestination , string $strCountry):string;
    public function validateTravelStyle(string $strTravelStyle):TravelStyle;
    public function validateCity(string $strCountry , string $strCity):string;

}
