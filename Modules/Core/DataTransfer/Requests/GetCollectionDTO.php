<?php

namespace Modules\Core\DataTransfer\Requests;

use Modules\Core\DataTransfer\Contracts\FiltersDTO;
use Modules\Core\DataTransfer\Contracts\CollectionDTO;
use Modules\Core\DataTransfer\Contracts\PaginationDTO;

final class GetCollectionDTO implements CollectionDTO
{
    public function __construct(
        private readonly FiltersDTO $filtersDTO,
        private readonly PaginationDTO $paginationDTO,
    ) {}

    public static function create(FiltersDTO $filtersDTO, PaginationDTO $paginationDTO): self
    {
        return new self($filtersDTO, $paginationDTO);
    }

    public function getPagination(): PaginationDTO
    {
        return $this->paginationDTO;
    }

    public function getFilters(): FiltersDTO
    {
        return $this->filtersDTO;
    }
}
