<?php

namespace Modules\Tour\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Modules\Tour\Contracts\Repositories\DestinationRepositoryContract;
use Modules\Tour\Contracts\Services\DestinationContract;
use Modules\Tour\Entities\Destination;
use Modules\Tour\DataTransfer\Requests\DestinationDTO;

class DestinationService implements DestinationContract
{
    public function __construct(
        //Repositories
        private readonly DestinationRepositoryContract $objDestinationRepository,
    ) {}

    /**
     * @param DestinationDTO $createDestinationDTO
     * @return Destination
     */
    public function create(DestinationDTO $createDestinationDTO): Destination
    {
        $objDestination = $this->objDestinationRepository->create(
            $createDestinationDTO->getName(),
            $createDestinationDTO->getContent()
        );
        if(!is_null($createDestinationDTO->getImage()))
            $this->saveImage($objDestination , $createDestinationDTO->getImage());
        if(!is_null($createDestinationDTO->getSlider()))
            $this->saveSlider($objDestination , $createDestinationDTO->getSlider());
        return $objDestination;
    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->objDestinationRepository->getDestinations();
    }

    /**
     * @param string $id
     * @return Destination|null
     */
    public function findById(string $id): ?Destination
    {
        return $this->objDestinationRepository->findById($id);
    }

    /**
     * @param string $id
     * @return Destination|null
     */
    public function findByUuid(string $id): ?Destination
    {
        return $this->objDestinationRepository->findByUuid($id);
    }

    /**
     * @param Destination $destination
     * @return bool|null
     */
    public function delete(Destination $destination): ?bool
    {
        return $this->objDestinationRepository->deleteDestination($destination);
    }

    /**
     * @param Destination $objDestination
     * @param DestinationDTO $updateDestinationDTO
     * @return Destination
     */
    public function update(Destination $objDestination, DestinationDTO $updateDestinationDTO): Destination
    {
        $objDestination = $this->objDestinationRepository->updateDestination(
            $objDestination,
            $updateDestinationDTO->getName(),
            $updateDestinationDTO->getContent(),
            $updateDestinationDTO->getImage(),

        );

        if(!is_null($updateDestinationDTO->getImage()))
            $this->saveImage($objDestination , $updateDestinationDTO->getImage());
        if(!is_null($updateDestinationDTO->getSlider()))
            $this->saveSlider($objDestination , $updateDestinationDTO->getSlider());
        return $objDestination;
    }

    /**
     * @param Destination $objDestination
     * @param array $sliderFiles
     * @return void
     */
    public function saveSlider(Destination $objDestination, array $sliderFiles): void
    {
        foreach ($sliderFiles as $item) {
            $objDestination->setSlider($item);
        }
    }

    /**
     * @param Destination $objDestination
     * @param UploadedFile $file
     * @return void
     */
    public function saveImage(Destination $objDestination, UploadedFile $file): void
    {
        $objDestination->setImage($file);
    }
}
