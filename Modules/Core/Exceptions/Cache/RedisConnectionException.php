<?php

namespace Modules\Core\Exceptions\Cache;

use Modules\Core\Exceptions\ApiException;
use Modules\Core\Enum\Response\ResponseCode;
use Symfony\Component\HttpFoundation\Response;

final class RedisConnectionException extends \Exception implements ApiException
{
    public function __construct()
    {
        parent::__construct(
            "Invalid Cache Connection.",
            Response::HTTP_NOT_ACCEPTABLE
        );
    }

    public function getSystemCode(): ResponseCode
    {
        return ResponseCode::CACHE_CONNECTION;
    }
}
