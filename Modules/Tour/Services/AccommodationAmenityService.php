<?php

namespace Modules\Tour\Services;

use Illuminate\Support\Collection;
use Modules\Tour\Contracts\Repositories\AccommodationAmenityRepositoryContract;
use Modules\Tour\Contracts\Repositories\AccommodationRepositoryContract;
use Modules\Tour\Contracts\Services\AccommodationAmenityContract;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\TourAccommodation;

class AccommodationAmenityService implements AccommodationAmenityContract
{
    public function __construct(
        //Repositories
        private readonly AccommodationRepositoryContract $objAccommodationRepository,
        private readonly AccommodationAmenityRepositoryContract $objAccommodationAmenityRepository,
    ) {}

    /**
     * @param TourAccommodation $objTourAccommodation
     * @param int $accIndex
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveAccommodationAmenities(TourAccommodation $objTourAccommodation , int $accIndex , TourDTO $objTourDTO):Collection{
        $objAccommodationAmenities = [];
        $objAccommodationAmenity = $objTourDTO->getAccommodationAmenity($accIndex);
        foreach ($objAccommodationAmenity as $index => $item) {
            $objAccommodationAmenities[] = $this->objAccommodationAmenityRepository->create(
                $objTourDTO->getAccommodationAmenityMetaKey($accIndex , $index),
                $objTourDTO->getAccommodationAmenityMetaValue($accIndex , $index),
                $objTourDTO->getAccommodationAmenityIcon($accIndex , $index),
            );
        }
        return $this->objAccommodationRepository->saveAmenities($objTourAccommodation , $objAccommodationAmenities);
    }

    /**
     * @param TourAccommodation $objTourAccommodation
     * @param int $accIndex
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateAccommodationAmenities(TourAccommodation $objTourAccommodation , int $accIndex , TourDTO $objTourDTO):Collection{
        $existingAccommodationAmenityIds = $objTourAccommodation->ammenities()->pluck('id')->toArray();
        $incomingAccommodationAmenityIds = [];
        $accommodationAmenities = $objTourDTO->getAccommodationAmenity($accIndex);
        $objNewAccommodationAmenities = [];
        foreach ($accommodationAmenities as $index => $item) {
            $incomingAccommodationAmenityIds[] = $objTourDTO->getAccommodationAmenityId($accIndex , $index);
            $objAccommodationAmenity = $this->objAccommodationAmenityRepository->findById($objTourDTO->getAccommodationAmenityId($accIndex , $index));
            !is_null($objAccommodationAmenity)?
                $this->objAccommodationAmenityRepository->update(
                    $objAccommodationAmenity,
                    $objTourDTO->getAccommodationAmenityMetaKey($accIndex , $index),
                    $objTourDTO->getAccommodationAmenityMetaValue($accIndex , $index),
                    $objTourDTO->getAccommodationAmenityIcon($accIndex , $index),
                ) :
                $objNewAccommodationAmenities[] = $this->objAccommodationAmenityRepository->create(
                    $objTourDTO->getAccommodationAmenityMetaKey($accIndex , $index),
                    $objTourDTO->getAccommodationAmenityMetaValue($accIndex , $index),
                    $objTourDTO->getAccommodationAmenityIcon($accIndex , $index),
                );
        }
        if(!is_null($objNewAccommodationAmenities))
            $this->objAccommodationRepository->saveAmenities($objTourAccommodation , $objNewAccommodationAmenities);
        $accommodationsAmenitiesToDelete = array_diff($existingAccommodationAmenityIds, $incomingAccommodationAmenityIds);
        if(!empty($accommodationsAmenitiesToDelete)) {
            $this->deleteAccommodationAmenities($accommodationsAmenitiesToDelete);
        }
        return $objTourAccommodation->ammenities;
    }

    /**
     * @param array $accommodationAmenitiesToDelete
     * @return void
     */
    public function deleteAccommodationAmenities(array $accommodationAmenitiesToDelete):void{
        foreach ($accommodationAmenitiesToDelete as $accommodationAmenityId){
            $objAccommodationAmenityDelete = $this->objAccommodationAmenityRepository->findById($accommodationAmenityId);
            $this->objAccommodationAmenityRepository->delete($objAccommodationAmenityDelete);
        }
    }


}
