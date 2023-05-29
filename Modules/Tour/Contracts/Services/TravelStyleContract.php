<?php

namespace Modules\Tour\Contracts\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Modules\Tour\DataTransfer\Requests\TravelStyleDTO;
use Modules\Tour\Entities\TravelStyle;

interface TravelStyleContract
{

    /**
     * @param TravelStyleDTO $travelStyleCreateDTO
     * @return TravelStyle
     */
    public function create(TravelStyleDTO $travelStyleCreateDTO): TravelStyle;

    /**
     * @return Collection
     */
    public function get() :Collection;

    /**
     * @param string $id
     * @return TravelStyle|null
     */
    public function findById(string $id): ?TravelStyle;

    /**
     * @param string $id
     * @return TravelStyle|null
     */
    public function findByUuid(string $id): TravelStyle|null;

    /**
     * @param TravelStyle $travelStyle
     * @return bool|null
     */
    public function delete(TravelStyle $travelStyle): ?bool;


    /**
     * @param TravelStyle $objTravelStyle
     * @param TravelStyleDTO $updateTravelStyleDTO
     * @return TravelStyle
     */
    public function update(TravelStyle $objTravelStyle , TravelStyleDTO $updateTravelStyleDTO): TravelStyle;

    /**
     * @param TravelStyle $objTravelStyle
     * @param array $sliderFiles
     * @return void
     */


    public function saveSlider(TravelStyle $objTravelStyle , array $sliderFiles):void;

    /**
     * @param TravelStyle $objTravelStyle
     * @param UploadedFile $file
     * @return void
     */
    public function saveImage(TravelStyle $objTravelStyle , UploadedFile $file):void;


}
