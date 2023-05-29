<?php

namespace Modules\Tour\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\EssentialInfoRepositoryContract;
use Modules\Tour\Entities\TourEssentialInfo;

class EssentialInfoRepository implements EssentialInfoRepositoryContract
{
    public function __construct(private readonly TourEssentialInfo $model) {}


    /**
     * @param string $strTitle
     * @param string $strDescription
     * @return TourEssentialInfo
     */
    public function create(string $strTitle,
                           string $strDescription,
    ): TourEssentialInfo{
        $objTourEssentialInfo = new TourEssentialInfo([
            'title' => $strTitle,
            'description' => $strDescription,
            'tour_essential_info_uuid' => Str::uuid()
        ]);
        return $objTourEssentialInfo;
    }

    /**
     * @param int $id
     * @return Model|TourEssentialInfo|null
     */
    public function findById(int|null $id): Model|TourEssentialInfo|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereTourEssentialInfoUuid($id)->first();
    }

    /**
     * @param TourEssentialInfo $objTourEssentialInfo
     * @return bool
     */
    public function delete(TourEssentialInfo $objTourEssentialInfo): bool
    {
        $objTourEssentialInfo->medially()->delete();
        return $objTourEssentialInfo->delete();
    }

    /**
     * @param TourEssentialInfo $objTourEssentialInfo
     * @param string $strTitle
     * @param string $strDescription
     * @return TourEssentialInfo
     */
    public function update(TourEssentialInfo $objTourEssentialInfo,
                           string $strTitle,
                           string $strDescription,
    ): TourEssentialInfo
    {
        if (is_string($strTitle) && $objTourEssentialInfo->title !== $strTitle)
            $objTourEssentialInfo->title = $strTitle;
        if (is_string($strDescription) && $objTourEssentialInfo->description !== $strDescription)
            $objTourEssentialInfo->description = $strDescription;
        $objTourEssentialInfo->update();
        return $objTourEssentialInfo;
    }
}
