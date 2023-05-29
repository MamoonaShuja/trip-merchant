<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Support\Collection;
use Modules\Tour\Entities\Destination;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface DestinationRepositoryContract
{
    /**
     * @param string $name
     * @param string $content
     * @param UploadedFile|null $file
     * @return Destination
     */
    public function create(
        string   $name,
        string   $content,
    ): Destination;

    /**
     * @return Collection|null
     */
    public function getDestinations(): ?Collection;

    /**
     * @param string $id
     * @return Destination|null
     */
    public function findById(string $id): ?Destination;

    /**
     * @param string $id
     * @return Destination|null
     */
    public function findByUuid(string $id): ?Destination;

    /**
     * @param Destination $destination
     * @return bool
     */
    public function deleteDestination(Destination $destination): bool;

    /**
     * @param Destination $objDestination
     * @param string|null $strName
     * @param string|null $strContent
     * @param UploadedFile|null $uploadedFile
     * @return Destination
     */
    public function updateDestination(
        Destination $objDestination,
        ?string $strName = null,
        ?string $strContent= null,
        ?UploadedFile $uploadedFile = null,
    ): Destination;

    public function findByName(string $strName):Destination|null;
}
