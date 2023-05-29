<?php

namespace Modules\Tour\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Services\DepartureDateContract;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Repositories\DepartureDateRepository;

class DepartureDateService implements DepartureDateContract
{
    public function __construct(
        //Repositories
        private readonly TourRepositoryContract $objTourRepository,
        private readonly DepartureDateRepository $objDepartureDateRepository,
    ) {}
    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveDepartureDates(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection{
        $objDates = [];
        $dates = $objTourDTO->getDepartureDates();
        foreach ($dates as $index => $item) {
            $objDates[] = $this->objDepartureDateRepository->create(
                $objTourDTO->getDepartureDatesYear($index),
                $objTourDTO->getDepartureDatesStartDate($index),
                $objTourDTO->getDepartureDatesEndDate($index),
                $objTourDTO->getDepartureDatesAvailability($index),
                $objTourDTO->getDepartureDatesPrice($index),
            );
        }
        return $this->objTourRepository->saveDepartureDates($objTour , $objDates);
    }

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateDepartureDates(Tour $objTour , TourDTO $objTourDTO):Collection{
        $existingDepartureDateIds = $objTour->departureDates()->pluck('id')->toArray();
        $incomingDepartureDateIds = [];
        $departureDate = $objTourDTO->getDepartureDates();
        $objNewDepartureDate = [];
        foreach ($departureDate as $index => $item) {
            $incomingDepartureDateIds[] = $objTourDTO->getDepartureDatesId($index);
            $objDepartureDate = $this->objDepartureDateRepository->findById($objTourDTO->getDepartureDatesId($index));
            (!is_null($objDepartureDate)) ?
                $this->objDepartureDateRepository->update(
                    $objDepartureDate,
                    $objTourDTO->getDepartureDatesYear($index),
                    $objTourDTO->getDepartureDatesStartDate($index),
                    $objTourDTO->getDepartureDatesEndDate($index),
                    $objTourDTO->getDepartureDatesAvailability($index),
                    $objTourDTO->getDepartureDatesPrice($index),
                ) :
                $objNewDepartureDate[] = $this->objDepartureDateRepository->create(
                    $objTourDTO->getDepartureDatesYear($index),
                    $objTourDTO->getDepartureDatesStartDate($index),
                    $objTourDTO->getDepartureDatesEndDate($index),
                    $objTourDTO->getDepartureDatesAvailability($index),
                    $objTourDTO->getDepartureDatesPrice($index),
                );
        }
        if(!is_null($objNewDepartureDate))
            $this->objTourRepository->saveDepartureDates($objTour , $objNewDepartureDate);
        $departureDatesToDelete = array_diff($existingDepartureDateIds, $incomingDepartureDateIds);
        $this->deleteDepartureDates($departureDatesToDelete);

        return $objTour->departureDates;
    }

    /**
     * @param array $departureDatesToDelete
     * @return void
     */
    public function deleteDepartureDates(array $departureDatesToDelete):void{
        foreach ($departureDatesToDelete as $departureDateId){
            $objDepartureDateDelete = $this->objDepartureDateRepository->findById($departureDateId);
            $this->objDepartureDateRepository->delete($objDepartureDateDelete);
        }
    }

}
