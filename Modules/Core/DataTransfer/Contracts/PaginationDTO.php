<?php

namespace Modules\Core\DataTransfer\Contracts;

use Modules\Core\DataTransfer\DTO;

interface PaginationDTO extends DTO
{
    public function isPaginated(): bool;
    public function getPerPage(): int;
    public function getPage(): int;
}
