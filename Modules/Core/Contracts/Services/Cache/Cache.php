<?php

namespace Modules\Core\Contracts\Services\Cache;

interface Cache
{
    public function set(string $key, mixed $value): mixed;
    public function get(string $key, mixed $default = null): mixed;
    public function forget(string $key): bool;
}
