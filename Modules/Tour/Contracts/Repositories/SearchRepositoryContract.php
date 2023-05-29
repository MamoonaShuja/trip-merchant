<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\Tour;
use Modules\User\Entities\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface SearchRepositoryContract
{
    /**
     * @param string|null $strTripName
     * @param string|null $strDestinationId
     * @param string|null $strDate
     * @param string|null $strCityId
     * @param string|null $strCountryId
     * @return Collection
     */
    public function generalFilter(string|null $strTripName, string|null $strDestinationId, string|null $strDate, string|null $strCityId, string|null $strCountryId, string|null $strTravelStyleId, string|null $strSupplierId, string|null $strStartDate, string|null $strEndDate, string|null $strStartPrice, string|null $strEndPrice): \Illuminate\Pagination\LengthAwarePaginator;


    /**
     * @param string|null $strSupplierId
     * @param string|null $strDestinationId
     * @param string|null $strStartDate
     * @param string|null $strEndDate
     * @param string|null $strStartPrice
     * @param string|null $strEndPrice
     * @param string|null $strItineraryName
     * @param string|null $strTravelStyleId
     * @return LengthAwarePaginator|null
     */
    public function guidedTourFilter(
        string|null $strTravelStyleId,
        string|null $strSupplierId,
        string|null $strDestinationId,
        string|null $strStartDate,
        string|null $strEndDate,
        string|null $strStartPrice,
        string|null $strEndPrice,
        string|null $strItineraryName
    ): LengthAwarePaginator|null;


}
