<?php

namespace Modules\Tour\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Tour\Contracts\Repositories\SearchRepositoryContract;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Services\AccommodationContract;
use Modules\Tour\Contracts\Services\DepartureDateContract;
use Modules\Tour\Contracts\Services\EssentialInfoContract;
use Modules\Tour\Contracts\Services\ItineraryContract;
use Modules\Tour\Contracts\Services\LocationContract;
use Modules\Tour\Contracts\Services\SearchContract;
use Modules\Tour\Contracts\Services\TourContract;
use Modules\Tour\Contracts\Services\VideoContract;
use Modules\Tour\DataTransfer\Requests\GeneralFilterDTO;
use Modules\Tour\DataTransfer\Requests\GuidedTourFilterDTO;
use Modules\Tour\DataTransfer\Requests\OceanCruisesFilterDTO;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TravelStyle;
use Modules\Tour\DataTransfer\Requests\TravelStyleDTO;
use Modules\User\Entities\User;

class SearchService implements SearchContract
{
    public function __construct(
        //Repositories
        private readonly SearchRepositoryContract $objSearchRepository,
    )
    {
    }

    /**
     * @param string|null $strTripName
     * @param string|null $strDestinationId
     * @param string|null $strDate
     * @param string|null $strCityId
     * @param string|null $strCountryId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function generalFilter(GeneralFilterDTO $generalFilterDTO): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->objSearchRepository->generalFilter($generalFilterDTO->getName(), $generalFilterDTO->getDestinationId(), $generalFilterDTO->getDate(), $generalFilterDTO->getCityId(), $generalFilterDTO->getCountryId(), $generalFilterDTO->getTravelStyleId(), $generalFilterDTO->getSupplierId(), $generalFilterDTO->getStartDate(), $generalFilterDTO->getEndDate(), $generalFilterDTO->getStartPrice(), $generalFilterDTO->getEndPrice());
    }

    /**
     * @param GuidedTourFilterDTO $guidedTourFilterDTO
     * @return Collection|null
     */
    public function guidedTourFilter(GuidedTourFilterDTO $guidedTourFilterDTO): \Illuminate\Pagination\LengthAwarePaginator|null
    {
        return $this->objSearchRepository->guidedTourFilter($guidedTourFilterDTO->getTravelStyleId(), $guidedTourFilterDTO->getSupplierId(), $guidedTourFilterDTO->getDestinationId(), $guidedTourFilterDTO->getStartDate(), $guidedTourFilterDTO->getEndDate(), $guidedTourFilterDTO->getStartPrice(), $guidedTourFilterDTO->getEndPrice(), $guidedTourFilterDTO->getItineraryName());
    }


}
