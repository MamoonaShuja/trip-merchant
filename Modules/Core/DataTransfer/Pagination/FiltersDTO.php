<?php

namespace Modules\Core\DataTransfer\Pagination;

final class FiltersDTO implements \Modules\Core\DataTransfer\Contracts\FiltersDTO
{
    public function __construct(
        private array $filters
    ) {}

    public static function create(array $filters): self
    {
        return new self($filters);
    }

    public function getAllFilters(): array
    {
        return $this->filters;
    }

    public function getFilter(string $key, mixed $default = null): mixed
    {
        return $this->filters[$key] ?? $default;
    }

    public function setFilter(string $key, mixed $value)
    {
        $this->filters[$key] = $value;
    }

    public function hasFilter(string $key): bool
    {
        return array_key_exists($key, $this->filters);
    }
}
