<?php

namespace Modules\Core\Services\Cache;

use Predis\Client;
use Predis\Connection\ConnectionException;
use Modules\Core\Contracts\Services\Cache\Cache;
use Modules\Core\Exceptions\Cache\RedisConnectionException;

final class RedisService implements Cache
{
    private readonly Client $client;
    private readonly string $strPrefix;

    public function __construct(string $strHost, string $strPrefix)
    {
        $this->client = new Client([
            'host' => $strHost
        ]);
        $this->strPrefix = $strPrefix;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     * @throws RedisConnectionException
     */
    public function set(string $key, mixed $value): mixed
    {
        try {
            $this->client->set($this->formatKey($key), $value);
        } catch (ConnectionException) {
            throw new RedisConnectionException();
        }

        return $value;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return string|null
     * @throws RedisConnectionException
     */
    public function get(string $key, mixed $default = null): ?string
    {
        try {
            return $this->client->get($this->formatKey($key));
        } catch (ConnectionException) {
            throw new RedisConnectionException();
        }
    }

    /**
     * @param string $key
     * @return bool
     * @throws RedisConnectionException
     */
    public function forget(string $key): bool
    {
        try {
            return $this->client->del($this->formatKey($key));
        } catch (ConnectionException) {
            throw new RedisConnectionException();
        }
    }

    private function formatKey(string $key): string
    {
        if (strpos($key, $this->strPrefix)) {
            return $key;
        }

        return "{$this->strPrefix}.{$key}";
    }
}
