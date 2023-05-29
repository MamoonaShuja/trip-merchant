<?php

namespace Modules\Tour\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\DestinationRepositoryContract;
use Modules\Tour\Entities\Destination;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DestinationRepository implements DestinationRepositoryContract
{
    public function __construct(private readonly Destination $model) {}

    /**
     * @param string $name
     * @param string $content
     * @param UploadedFile|null $file
     * @return Destination
     */
    public function create(string $name, string $content): Destination
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->create([
            'name' => $name,
            'content' => $content,
            'destination_uuid' => Str::uuid()
        ]);
    }


    /**
     * @return Collection|null
     */
    public function getDestinations(): ?Collection
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->latest()->with(
            [
                'medially',
                "countries"
            ]
        )->get();
    }

    /**
     * @param string $id
     * @return Destination|null
     */
    public function findById(string $id): ?Destination
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->find($id);
    }

    public function findByUuid(string $id): ?Destination
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereDestinationUuid($id)->first();
    }

    /**
     * @param Destination $destination
     * @return bool
     */
    public function deleteDestination(Destination $destination): bool
    {
        return $destination->delete();
    }

    /**
     * @param Destination $objDestination
     * @param string|null $strName
     * @param string|null $strContent
     * @param UploadedFile|null $uploadedFile
     * @return Destination
     */
    public function updateDestination(Destination $objDestination, ?string $strName = null, ?string $strContent = null, ?UploadedFile $uploadedFile = null,): Destination
    {
        if (is_string($strName) && $objDestination->name !== $strName)
            $objDestination->name = $strName;
        if (is_string($strContent) && $objDestination->content !== $strContent)
            $objDestination->content = $strContent;
        $objDestination->update();
        return $objDestination;
    }
    public function findByName(string $strName):Destination|null{
        $objQuery = $this->model->newQuery();
        return $objQuery->whereName($strName)->first();
    }

}
