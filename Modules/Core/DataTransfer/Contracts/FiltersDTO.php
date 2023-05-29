<?php

namespace Modules\Core\DataTransfer\Contracts;

use Modules\Core\DataTransfer\DTO;

interface FiltersDTO extends DTO {
    public function getAllFilters(): array;
    public function getFilter(string $key, ?string $default = null): mixed;

    public function setFilter(string $key, string $value);

    public function hasFilter(string $key): bool;
}
