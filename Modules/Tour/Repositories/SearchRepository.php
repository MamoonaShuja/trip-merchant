<?php

namespace Modules\Tour\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Tour\Contracts\Repositories\SearchRepositoryContract;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\Tour;

class SearchRepository implements SearchRepositoryContract
{
    public function __construct(private readonly Tour $model)
    {
    }


    /**
     * @param string|null $strTripName
     * @param string|null $strDestinationId
     * @param string|null $strDate
     * @param string|null $strCityId
     * @param string|null $strCountryId
     * @param string|null $strTravelStyleId
     * @param string|null $strSupplierId
     * @param string|null $strStartDate
     * @param string|null $strEndDate
     * @param string|null $strStartPrice
     * @param string|null $strEndPrice
     * @return LengthAwarePaginator
     */
    public function generalFilter(string|null $strTripName, string|null $strDestinationId, string|null $strDate, string|null $strCityId, string|null $strCountryId, string|null $strTravelStyleId, string|null $strSupplierId, string|null $strStartDate, string|null $strEndDate, string|null $strStartPrice, string|null $strEndPrice): \Illuminate\Pagination\LengthAwarePaginator
    {
        $objQuery = $this->model->newQuery();
        $objTours = $objQuery->when($strTravelStyleId, function ($query) use ($strTravelStyleId) {
            return $query->Where('travel_style_id', $strTravelStyleId);
            })
            ->when($strTripName, function ($query) use ($strTripName) {
                return $query->Where('title', 'like', '%' . $strTripName . '%');
            })->when($strDestinationId, function ($query) use ($strDestinationId) {
                $query->whereHas('destinations', function ($query) use ($strDestinationId) {
                    return $query->where('destinations.id', $strDestinationId);
                });
            })->when($strDate, function ($query) use ($strDate) {
                $date = Carbon::createFromFormat('d-m-Y', $strDate);
                // format the date as a string in the format "Y-m-d"
                $strDate = $date->format('Y-m-d');
                return $query->whereHas('departureDates', function ($query) use ($strDate) {
                    return $query->where('start_date', '<=', $strDate)
                        ->where('end_date', '>=', $strDate);
                });
            })->when($strCityId, function ($query) use ($strCityId) {
                return $query->whereArrivalCityId($strCityId)
                    ->orWhere('departure_city_id', $strCityId);
            })
            ->when($strCountryId, function ($query) use ($strCountryId) {
                return $query->whereCountryId($strCountryId);
            })
            ->when($strTravelStyleId, function ($query) use ($strTravelStyleId) {
                return $query->where('travel_style_id', $strTravelStyleId);
            })
            ->when($strSupplierId, function ($query) use ($strSupplierId) {
                return $query->Where('supplier_id', $strSupplierId);
            })->when($strStartDate, function ($query) use ($strStartDate) {
                $date = Carbon::createFromFormat('d-m-Y', $strStartDate);
                // format the date as a string in the format "Y-m-d"
                $strDate = $date->format('Y-m-d');
                return $query->whereHas('departureDates', function ($query) use ($strDate) {
                    return $query->where('start_date', '<=', $strDate);
                });
            })->when($strEndDate, function ($query) use ($strEndDate) {
                $date = Carbon::createFromFormat('d-m-Y', $strEndDate);
                // format the date as a string in the format "Y-m-d"
                $strDate = $date->format('Y-m-d');
                return $query->whereHas('departureDates', function ($query) use ($strDate) {
                    return $query->where('end_date', '>=', $strDate);
                });
            })->when($strStartPrice && $strEndPrice, function ($query) use ($strStartPrice, $strEndPrice) {
                return $query->whereBetween("members_rate", [$strStartPrice, $strEndPrice]);
            })->when($strStartPrice && !$strEndPrice, function ($query) use ($strStartPrice) {
                return $query->where("members_rate", ">=", $strStartPrice);
            })->when(!$strStartPrice && $strEndPrice, function ($query) use ($strEndPrice) {
                return $query->where("members_rate", "<=", $strEndPrice);
            })
            ->paginate(config('app.pages'));
        return $objTours;
    }


    /**
     * @param string|null $strSupplierId
     * @param string|null $strDestinationId
     * @param string|null $strStartDate
     * @param string|null $strEndDate
     * @param string|null $strStartPrice
     * @param string|null $strEndPrice
     * @param string|null $strItineraryName
     * @return Collection
     */
    public function guidedTourFilter(string|null $strTravelStyleId, string|null $strSupplierId, ?string $strDestinationId, ?string $strStartDate, ?string $strEndDate, ?string $strStartPrice, ?string $strEndPrice, ?string $strItineraryName): LengthAwarePaginator|null
    {
        $objQuery = $this->model->newQuery();
        $objTours = $objQuery->Search($strTravelStyleId, $strSupplierId, $strDestinationId, $strStartDate, $strEndDate, $strStartPrice, $strEndPrice, $strItineraryName)->paginate(config('app.pages'));;
        return $objTours;
    }


}
