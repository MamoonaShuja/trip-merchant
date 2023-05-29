<?php

namespace Modules\Tour\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\Contracts\Repositories\CabinDeckRepositoryContract;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Services\CabinDeckContract;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

class CabinDeckService implements CabinDeckContract
{
    public function __construct(
        //Repositories
        private readonly TourRepositoryContract $objTourRepository,
        private readonly CabinDeckRepositoryContract $objCaninDeckRepository,
    ) {}

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveCabinDecks(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection{
        $objCabinDecks = [];
        $cabinDeck = $objTourDTO->getCabinDecks();
        foreach ($cabinDeck as $index => $item) {
            $objCabinDeck = $this->objCaninDeckRepository->create(
                $objTourDTO->getCabinDeckTitle($index),
                $objTourDTO->getCabinDeckDescription($index),
            );
            $objCabinDecks[] = $objCabinDeck;
        }
        $newCabinDecks = $this->objTourRepository->saveCabinDecks($objTour , $objCabinDecks);
        $this->savePdfs($newCabinDecks , $objTourDTO);
        return $newCabinDecks;
    }

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateCabinDeck(Tour $objTour , TourDTO $objTourDTO):Collection
    {
        $existingCabinDeckIds = $objTour->cabinDecks()->pluck('id')->toArray();
        $incomingCabinDeckIds = [];
        $cabinDecks = $objTourDTO->getCabinDecks();
        $objNewCabinDecks = [];
        foreach ($cabinDecks as $index => $item) {
            $incomingCabinDeckIds[] = $objTourDTO->getCabinDeckId($index);
            $objCabinDeck = $this->objCaninDeckRepository->findById($objTourDTO->getCabinDeckId($index));
            if(!is_null($objCabinDeck)){
                $objCabinDeckUpdate = $this->objCaninDeckRepository->update(
                    $objCabinDeck,
                    $objTourDTO->getCabinDeckTitle($index),
                    $objTourDTO->getCabinDeckDescription($index),
                );
                if(!is_null($objTourDTO->getCabinDeckPdf($index))){
                    $objCabinDeckUpdate->savePdf($objTourDTO->getCabinDeckPdf($index));
                }
            }else{
                $objNewCabinDecks[] = $this->objCaninDeckRepository->create(
                    $objTourDTO->getCabinDeckTitle($index),
                    $objTourDTO->getCabinDeckDescription($index),
                );
            }
        }
        if (!is_null($objNewCabinDecks)) {
            $objCabinDeckNew = $this->objTourRepository->saveCabinDecks($objTour, $objNewCabinDecks);
            $this->savePdfs($objCabinDeckNew , $objTourDTO);
        }
        $cabinDecksToDelete = array_diff($existingCabinDeckIds, $incomingCabinDeckIds);
        $this->deleteCabinDecks($cabinDecksToDelete);
        return $objTour->cabinDecks;
    }

    /**
     * @param array $cabinDecksToDelete
     * @return void
     */
    public function deleteCabinDecks(array $cabinDecksToDelete):void{
        foreach ($cabinDecksToDelete as $cabinDeckId){
            $objCabinDeckDelete = $this->objCaninDeckRepository->findById($cabinDeckId);
            if(!is_null($objCabinDeckDelete))
                $this->objCaninDeckRepository->delete($objCabinDeckDelete);
        }
    }


    /**
     * @param Collection $savedEssentialInfos
     * @param TourDTO $objTourDTO
     * @return void
     */
    public function savePdfs(Collection $savedCabinDecks , TourDTO $objTourDTO){
        foreach ($savedCabinDecks as $index => $savedCabinDeck){
            if(!is_null($objTourDTO->getCabinDeckPdf($index)))
                $savedCabinDeck->savePdf($objTourDTO->getCabinDeckPdf($index));
        }
    }
}
