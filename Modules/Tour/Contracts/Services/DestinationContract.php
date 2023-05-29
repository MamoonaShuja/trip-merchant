<?php

namespace Modules\Tour\Contracts\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Modules\Tour\DataTransfer\Requests\DestinationDTO;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\Tour;

interface DestinationContract
{
    /**
     * @param DestinationDTO $destinationCreateDTO
     * @return Destination
     */
    public function create(DestinationDTO $destinationCreateDTO): Destination;

    /**
     * @return Collection
     */
    public function get() :Collection;

    /**
     * @param string $id
     * @return Destination|null
     */
    public function findById(string $id): ?Destination;

    /**
     * @param string $id
     * @return Destination|null
     */
    public function findByUuid(string $id): Destination|null;

    /**
     * @param Destination $destination
     * @return bool|null
     */
    public function delete(Destination $destination): ?bool;


    /**
     * @param Destination $objDestination
     * @param DestinationDTO $updateDestinationDTO
     * @return Destination
     */
    public function update(Destination $objDestination , DestinationDTO $updateDestinationDTO): Destination;

    /**
     * @param Destination $objDestination
     * @param array $sliderFiles
     * @return void
     */


    public function saveSlider(Destination $objDestination , array $sliderFiles):void;

    /**
     * @param Destination $objDestination
     * @param UploadedFile $file
     * @return void
     */
    public function saveImage(Destination $objDestination , UploadedFile $file):void;


}
