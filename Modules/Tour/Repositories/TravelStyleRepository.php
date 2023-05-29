<?php

namespace Modules\Tour\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\TravelStyleRepositoryContract;
use Modules\Tour\Entities\TravelStyle;
use Modules\Tour\Enum\MediaTypes;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TravelStyleRepository implements TravelStyleRepositoryContract
{
    public function __construct(private readonly TravelStyle $model) {}

    /**
     * @param string $name
     * @param string $content
     * @param bool $is_group
     * @return TravelStyle
     */
    public function create(string $name, string $content, bool $is_group): TravelStyle
    {
        $objQuery = $this->model->newQuery();
        $objTravelStyle = $objQuery->create([
            'name' => $name,
            'content' => $content,
            'is_group' => $is_group,
            'travel_style_uuid' => Str::uuid()
        ]);
        return $objTravelStyle;
    }


    /**
     * @return Collection|null
     */
    public function getTravelStyles(): ?Collection
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->latest()->get();
    }

    /**
     * @param int|null $id
     * @return TravelStyle|null
     */
    public function findById(int|null $id): TravelStyle|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->find($id);
    }
    /**
     * @param int|null $id
     * @return TravelStyle|null
     */
    public function findByUuid(string $id): TravelStyle|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereTravelStyleUuid($id)->first();
    }

    /**
     * @param TravelStyle $travelStyle
     * @return bool
     */
    public function deleteTravelStyle(TravelStyle $travelStyle): bool
    {
        return $travelStyle->delete();
    }

    /**
     * @param TravelStyle $objTravelStyle
     * @param string|null $strName
     * @param string|null $strContent
     * @param UploadedFile|null $uploadedFile
     * @return TravelStyle
     */
    public function updateTravelStyle(TravelStyle $objTravelStyle, ?string $strName = null, ?string $strContent = null, ? bool $isGroup = null, null|UploadedFile $uploadedFile = null,): TravelStyle
    {
        if (is_string($strName) && $objTravelStyle->name !== $strName)
            $objTravelStyle->name = $strName;
        if (is_string($strContent) && $objTravelStyle->content !== $strContent)
            $objTravelStyle->content = $strContent;
        if (is_bool($isGroup) && $objTravelStyle->is_group !== $isGroup)
            $objTravelStyle->is_group = $isGroup;
        if($uploadedFile != null):
            $objTravelStyle->setImage($uploadedFile);
        endif;
        $objTravelStyle->update();
        return $objTravelStyle;
    }

    /**
     * @param string $strName
     * @return TravelStyle|null
     */
    public function findByName(string $strName): TravelStyle|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereName($strName)->first();
    }
}
