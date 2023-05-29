<?php

namespace Modules\Core\Exceptions\Http;

use Modules\Core\Exceptions\ApiException;
use Modules\Core\Enum\Response\ResponseCode;
use Symfony\Component\HttpFoundation\Response;

final class InvalidUserAgent extends \Exception implements ApiException
{
    public function __construct()
    {
        parent::__construct(
            "Invalid User Agent.",
            Response::HTTP_BAD_REQUEST,
        );
    }

    public function getSystemCode(): ResponseCode
    {
        return ResponseCode::DEFAULT_ERROR;
    }
}
