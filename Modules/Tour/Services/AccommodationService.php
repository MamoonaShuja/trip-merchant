<?php

namespace Modules\Tour\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\Contracts\Repositories\AccommodationRepositoryContract;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Services\AccommodationAmenityContract;
use Modules\Tour\Contracts\Services\AccommodationContract;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

class AccommodationService implements AccommodationContract
{
    public function __construct(
        //Repositories
        private readonly TourRepositoryContract $objTourRepository,
        private readonly AccommodationRepositoryContract $objAccommodationRepository,
        private readonly AccommodationAmenityContract $objAccommodationAmenityService,
    ) {}

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveAccommodations(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection{
        $objAccommodations = [];
        $accommodations = $objTourDTO->getAccommodations();
        foreach ($accommodations as $index => $item) {
            $objAccommodations[] = $this->objAccommodationRepository->create(
                $objTourDTO->getAccommodationHotelName($index),
            );
        }
        $objAccommodations =  $this->objTourRepository->saveAccommodations($objTour , $objAccommodations);
        foreach ($objAccommodations as $accIndex => $objAccommodation) {
            $this->objAccommodationAmenityService->saveAccommodationAmenities($objAccommodation , $accIndex , $objTourDTO);
        }
        return $objAccommodations;
    }

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateAccommodations(Tour $objTour , TourDTO $objTourDTO):Collection{
        $existingAccommodationIds = $objTour->accommodations()->pluck('id')->toArray();
        $incomingAccommodationIds = [];
        $accommodations = $objTourDTO->getAccommodations();
        $objNewAccommodations = [];
        foreach ($accommodations as $index => $item) {
            $incomingAccommodationIds[] = $objTourDTO->getAccommodationId($index);
            $objAccommodation = $this->objAccommodationRepository->findById($objTourDTO->getAccommodationId($index));
            if(!is_null($objAccommodation)):
                $this->objAccommodationRepository->update(
                    $objAccommodation,
                    $objTourDTO->getAccommodationHotelName($index),
                );
                $this->objAccommodationAmenityService->updateAccommodationAmenities($objAccommodation , $index , $objTourDTO);
            else:
                $objNewAccommodations[] = $this->objAccommodationRepository->create(
                    $objTourDTO->getAccommodationHotelName($index),
                );
            endif;
        }
        if(!empty($objNewAccommodations)):
            $objAccommodations = $this->objTourRepository->saveAccommodations($objTour , $objNewAccommodations);
            foreach ($objAccommodations as $accIndex => $objAccommodation) {
                $this->objAccommodationAmenityService->saveAccommodationAmenities($objAccommodation , $accIndex , $objTourDTO);
            }
        endif;
        $accommodationsToDelete = array_diff($existingAccommodationIds, $incomingAccommodationIds);
        $this->deleteAccommodations($accommodationsToDelete);
        return $objTour->accommodations;
    }


    /**
     * @param array $accommodationsToDelete
     * @return void
     */
    public function deleteAccommodations(array $accommodationsToDelete):void{
        foreach ($accommodationsToDelete as $accommodationId){
            $objAccommodationDelete = $this->objAccommodationRepository->findById($accommodationId);

            $this->objAccommodationRepository->delete($objAccommodationDelete);
        }
    }


}
