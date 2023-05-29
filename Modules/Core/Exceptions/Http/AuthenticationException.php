<?php

namespace Modules\Core\Exceptions\Http;

use Modules\Core\Exceptions\ApiException;
use Modules\Core\Enum\Response\ResponseCode;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException as BaseAuthenticationException;

final class AuthenticationException extends BaseAuthenticationException implements ApiException
{
    protected $code = Response::HTTP_UNAUTHORIZED;

    public function getSystemCode(): ResponseCode
    {
        return ResponseCode::AUTHENTICATION_ERROR;
    }
}
