<?php

namespace Modules\Core\DataTransfer\Pagination;

use Modules\Core\DataTransfer\DTO;
use Modules\Core\DataTransfer\Contracts\PaginationDTO as PaginationDTOContract;

final class PaginationDTO implements PaginationDTOContract
{
    public function __construct(
        private readonly bool $isPaginated,
        private readonly int $intPerPage,
        private readonly int $intPage
    ) {}

    public static function create(
        bool $isPaginated,
        int $intPerPage,
        int $intPage
    ): self {
        return new self($isPaginated, $intPerPage, $intPage);
    }

    /**
     * @return bool
     */
    public function isPaginated(): bool
    {
        return $this->isPaginated;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->intPerPage;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->intPage;
    }
}
