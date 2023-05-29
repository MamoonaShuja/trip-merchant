<?php

namespace Modules\Core\DataTransfer\Contracts;

use Modules\Core\DataTransfer\DTO;

interface CollectionDTO extends DTO
{
    public function getPagination(): PaginationDTO;
    public function getFilters(): FiltersDTO;
}
