<?php

namespace Modules\Tour\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Modules\Tour\Contracts\Repositories\TravelStyleRepositoryContract;
use Modules\Tour\Contracts\Services\TravelStyleContract;
use Modules\Tour\Entities\TravelStyle;
use Modules\Tour\DataTransfer\Requests\TravelStyleDTO;

class TravelStyleService implements TravelStyleContract
{
    public function __construct(
        //Repositories
        private readonly TravelStyleRepositoryContract $objTravelStyleRepository,
    ) {}


    /**
     * @param TravelStyleDTO $createTravelStyleDTO
     * @return TravelStyle
     */
    public function create(TravelStyleDTO $createTravelStyleDTO): TravelStyle
    {
        $objTravelStyle =  $this->objTravelStyleRepository->create(
            $createTravelStyleDTO->getName(),
            $createTravelStyleDTO->getContent(),
            $createTravelStyleDTO->getIsGroup(),
        );
        if(!is_null($createTravelStyleDTO->getImage())) {
            $this->saveImage($objTravelStyle, $createTravelStyleDTO->getImage());
            sleep(1);
        }
        if(!is_null($createTravelStyleDTO->getSlider()))
            $this->saveSlider($objTravelStyle , $createTravelStyleDTO->getSlider());
        return $objTravelStyle;
    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->objTravelStyleRepository->getTravelStyles();
    }

    /**
     * @param string $id
     * @return TravelStyle|null
     */
    public function findById(string $id): ?TravelStyle
    {
        return $this->objTravelStyleRepository->findById($id);
    }

    public function findByUuid(string $id): ?TravelStyle
    {
        return $this->objTravelStyleRepository->findByUuid($id);
    }

    /**
     * @param TravelStyle $travelStyle
     * @return bool|null
     */
    public function delete(TravelStyle $travelStyle): ?bool
    {
        return $this->objTravelStyleRepository->deleteTravelStyle($travelStyle);
    }

    /**
     * @param TravelStyle $objTravelStyle
     * @param TravelStyleDTO $updateTravelStyleDTO
     * @return TravelStyle
     */
    public function update(TravelStyle $objTravelStyle, TravelStyleDTO $updateTravelStyleDTO): TravelStyle
    {
        $objTravelStyle =  $this->objTravelStyleRepository->updateTravelStyle(
            $objTravelStyle,
            $updateTravelStyleDTO->getName(),
            $updateTravelStyleDTO->getContent(),
            $updateTravelStyleDTO->getIsGroup(),
            $updateTravelStyleDTO->getImage(),

        );
        if(!is_null($updateTravelStyleDTO->getImage()))
            $this->saveImage($objTravelStyle , $updateTravelStyleDTO->getImage());
        if(!is_null($updateTravelStyleDTO->getSlider()))
            $this->saveSlider($objTravelStyle , $updateTravelStyleDTO->getSlider());
        return $objTravelStyle;
    }


    /**
     * @param TravelStyle $objTravelStyle
     * @param array $sliderFiles
     * @return void
     */
    public function saveSlider(TravelStyle $objTravelStyle, array $sliderFiles): void
    {
        foreach ($sliderFiles as $item) {
            $objTravelStyle->setSlider($item);
            sleep(1);
        }
    }

    /**
     * @param TravelStyle $objTravelStyle
     * @param UploadedFile $file
     * @return void
     */
    public function saveImage(TravelStyle $objTravelStyle, UploadedFile $file): void
    {
        $objTravelStyle->setImage($file);
    }
}
