<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Tour\Entities\TourEssentialInfo;

interface EssentialInfoRepositoryContract
{
    /**
     * @param string $strTitle
     * @param string $strDescription
     * @return TourEssentialInfo
     */
    public function create(
        string $strTitle,
        string $strDescription,
      ): TourEssentialInfo;

    /**
     * @param int $id
     * @return Model|TourEssentialInfo|null
     */
    public function findById(int|null $id): Model|TourEssentialInfo|null;

    /**
     * @param TourEssentialInfo $tour
     * @return bool
     */
    public function delete(TourEssentialInfo $objTourEssentialInfo): bool;

    /**
     * @param TourEssentialInfo $objTourEssentialInfo
     * @param string $strTitle
     * @param string $strDescription
     * @return TourEssentialInfo
     */
    public function update(
        TourEssentialInfo $objTourEssentialInfo,
        string $strTitle,
        string $strDescription,
    ): TourEssentialInfo;
}
