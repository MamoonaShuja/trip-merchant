<?php

namespace Modules\Tour\Services;

use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\Contracts\Repositories\LocationRepositoryContract;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Services\LocationContract;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourLocation;

class LocationService implements LocationContract
{
    public function __construct(
        //Repositories
        private readonly TourRepositoryContract $objTourRepository,
        private readonly LocationRepositoryContract $objLocationRepository,
    ) {}

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveLocations(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection{
        $locations = $objTourDTO->getLocations();
        $objLocations = [];
        if(is_null($locations)){
            $locations = $objTourDTO->getLocationMapImages();
            foreach ($locations as $index => $item) {
                $objLocation = $this->objLocationRepository->create(
                    $objTourDTO->getLocationsMapImage($index)->getFilename(),
                    $objTourDTO->getLocationsMapImage($index)->getFilename(),
                    is_null($objTourDTO->getLocationMapImages()) ? 0 : 1
                );
                array_push($objLocations, $objLocation);
            }
        }else {
            foreach ($locations as $index => $item) {
                $objLocation = $this->objLocationRepository->create(
                    $objTourDTO->getLocationsLatitude($index),
                    $objTourDTO->getLocationsLongitude($index),
                    is_null($objTourDTO->getLocationsMapImage($index)) ? 0 : 1
                );
                array_push($objLocations , $objLocation);
            }
        }
        $savedLocation = $this->objTourRepository->saveLocations($objTour , $objLocations);
        $this->saveImages($savedLocation , $objTourDTO);
        return $savedLocation;
    }

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateLocations(Tour $objTour , TourDTO $objTourDTO):Collection
    {
        $existingLocationIds = $objTour->locations()->pluck('id')->toArray();
        $incomingLocationIds = [];
        $locations = $objTourDTO->getLocations();
        $objNewLocations = [];
        if (!is_null($locations)) {
            foreach ($locations as $index => $item) {
                $incomingLocationIds[] = $objTourDTO->getLocationsId($index);
                $objLocation = $this->objLocationRepository->findById($objTourDTO->getLocationsId($index));
                $objLocation != null ?
                    $this->objLocationRepository->update(
                        $objLocation,
                        $objTourDTO->getLocationsLatitude($index),
                        $objTourDTO->getLocationsLongitude($index),
                        is_null($objTourDTO->getLocationMapImages()) ? 1 : 0
                    ) :
                    $objNewLocations[] = $this->objLocationRepository->create(
                        $objTourDTO->getLocationsLatitude($index),
                        $objTourDTO->getLocationsLongitude($index),
                        is_null($objTourDTO->getLocationMapImages()) ? 1 : 0
                    );
            }
        }else{
            $locations = $objTourDTO->getLocationMapImages();
            foreach ($locations as $index => $item) {
                $incomingLocationIds[] = $objTourDTO->getLocationsId($index);
                $objLocation = $this->objLocationRepository->findById($objTourDTO->getLocationsId($index));
                $objLocation != null ?
                    $this->objLocationRepository->update(
                        $objLocation,
                        $objTourDTO->getLocationsMapImage($index)->getFilename(),
                        $objTourDTO->getLocationsMapImage($index)->getFilename(),
                        is_null($objTourDTO->getLocationsMapImage($index)) ? 1 : 0
                    ) :
                    $objNewLocations[] = $this->objLocationRepository->create(
                        $objTourDTO->getLocationsLatitude($index),
                        $objTourDTO->getLocationsLongitude($index),
                        is_null($objTourDTO->getLocationsMapImage($index)) ? 1 : 0
                    );
            }
        }
            if (!is_null($objNewLocations))
                $this->objTourRepository->saveLocations($objTour, $objNewLocations);
            $locationsToDelete = array_diff($existingLocationIds, $incomingLocationIds);
            $this->deleteLocations($locationsToDelete);
        return $objTour->locations;
    }

    /**
     * @param array $locationsToDelete
     * @return void
     */
    public function deleteLocations(array $locationsToDelete):void{
        foreach ($locationsToDelete as $locationId){
            $objLocationDelete = $this->objLocationRepository->findById($locationId);
            $this->objLocationRepository->delete($objLocationDelete);
        }
    }

    /**
     * @param Collection $savedLocations
     * @param TourDTO $objTourDTO
     * @return void
     */
    public function saveImages(Collection $savedLocations , TourDTO|ApiTourDTO $objTourDTO){
        /** @var TourLocation $savedLocation */
        if(get_class($objTourDTO) === TourDTO::class){
            if(is_null($objTourDTO->getLocationMapImages())){
                return;
            }
        }
        foreach ($savedLocations as $index => $savedLocation){
            if(!is_null($objTourDTO->getLocationsMapImage($index)))
                $savedLocation->saveImage($objTourDTO->getLocationsMapImage($index));
        }
    }

}
