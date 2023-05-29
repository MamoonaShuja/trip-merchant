<?php

namespace Modules\Tour\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Tour\DataTransfer\Requests\GeneralFilterDTO;
use Modules\Tour\DataTransfer\Requests\GuidedTourFilterDTO;
use Modules\Tour\DataTransfer\Requests\OceanCruisesFilterDTO;

interface SearchContract
{
    /**
     * @param GeneralFilterDTO $generalFilterDTO
     * @return Collection
     */
    public function generalFilter(GeneralFilterDTO $generalFilterDTO): LengthAwarePaginator;

    /**
     * @param GuidedTourFilterDTO $guidedTourFilterDTO
     * @return Collection|null
     */
    public function guidedTourFilter(GuidedTourFilterDTO $guidedTourFilterDTO): LengthAwarePaginator|null;

}
