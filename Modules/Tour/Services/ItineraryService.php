<?php

namespace Modules\Tour\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\Contracts\Repositories\ItineraryRepositoryContract;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Services\ItineraryContract;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

class ItineraryService implements ItineraryContract
{
    public function __construct(
        //Repositories
        private readonly TourRepositoryContract $objTourRepository,
        private readonly ItineraryRepositoryContract $objItineraryRepository,
    ) {}

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return void
     */
    public function saveItineraries(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection{
        $objItineraries = array();
        $itinerary = $objTourDTO->getItinerary();
        foreach ($itinerary as $index => $item) {
            $objItinerary = $this->objItineraryRepository->create(
                $objTourDTO->getItineraryDay($index),
                $objTourDTO->getItineraryHotelName($index),
                $objTourDTO->getItineraryDescription($index),
                $objTourDTO->getItineraryMeal($index),
                $objTourDTO->getItineraryOptional($index),
            );
            array_push($objItineraries , $objItinerary);
        }
        return $this->objTourRepository->saveItineraries($objTour , $objItineraries);
    }

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return void
     */
    public function updateItineraries(Tour $objTour , TourDTO $objTourDTO):Collection{
        $existingItineraryIds = $objTour->itinarary()->pluck('id')->toArray();
        $incomingItineraryIds = [];
        $itinerary = $objTourDTO->getItinerary();
        $objNewItineraries = [];
        foreach ($itinerary as $index => $item) {
            $incomingItineraryIds[] = $objTourDTO->getItineraryId($index);
            $objItinerary = $this->objItineraryRepository->findById($objTourDTO->getItineraryId($index));
            $objItinerary != null ?
                $this->objItineraryRepository->update(
                    $objItinerary,
                    $objTourDTO->getItineraryDay($index),
                    $objTourDTO->getItineraryHotelName($index),
                    $objTourDTO->getItineraryDescription($index),
                    $objTourDTO->getItineraryMeal($index),
                    $objTourDTO->getItineraryOptional($index),
                ) :
                $objNewItineraries[]   = $this->objItineraryRepository->create(
                    $objTourDTO->getItineraryDay($index),
                    $objTourDTO->getItineraryHotelName($index),
                    $objTourDTO->getItineraryDescription($index),
                    $objTourDTO->getItineraryMeal($index),
                    $objTourDTO->getItineraryOptional($index),
                );
        }
        if(!is_null($objNewItineraries))
            $this->objTourRepository->saveItineraries($objTour , $objNewItineraries);
        $itinerariesToDelete = array_diff($existingItineraryIds, $incomingItineraryIds);
        $this->deleteItineraries($itinerariesToDelete);

        return $objTour->itinarary;
    }

    /**
     * @param array $itinerariesToDelete
     * @return void
     */
    public function deleteItineraries(array $itinerariesToDelete):void{
        foreach ($itinerariesToDelete as $itineraryId){
            $objItineraryDelete = $this->objItineraryRepository->findById($itineraryId);
            $this->objItineraryRepository->delete($objItineraryDelete);
        }
    }
}
