<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Support\Collection;
use Modules\Tour\Entities\TravelStyle;
use Modules\Tour\Enum\TravelStyleTypes;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface TravelStyleRepositoryContract
{

    /**
     * @param string $name
     * @param string $content
     * @param bool $is_group
     * @param UploadedFile|null $file
     * @return TravelStyle
     */
    public function create(
        string   $name,
        string   $content,
        bool   $is_group,
    ): TravelStyle;

    /**
     * @return Collection|null
     */
    public function getTravelStyles(): ?Collection;

    /**
     * @param string $id
     * @return TravelStyle|null
     */
    public function findById(int|null $id): ?TravelStyle;

    /**
     * @param string $id
     * @return TravelStyle|null
     */
    public function findByUuid(string $id): TravelStyle|null;

    /**
     * @param TravelStyle $travelStyle
     * @return bool
     */
    public function deleteTravelStyle(TravelStyle $travelStyle): bool;


    /**
     * @param TravelStyle $objTravelStyle
     * @param string|null $strName
     * @param string|null $strContent
     * @param bool|null $isGroup
     * @param UploadedFile|null $uploadedFile
     * @return TravelStyle
     */
    public function updateTravelStyle(
        TravelStyle $objTravelStyle,
        ?string $strName = null,
        ?string $strContent= null,
        ?bool $isGroup= null,
        ?UploadedFile $uploadedFile = null,
    ): TravelStyle;

    /**
     * @param string $strName
     * @return TravelStyle|null
     */
    public function findByName(string $strName):TravelStyle|null;
}
