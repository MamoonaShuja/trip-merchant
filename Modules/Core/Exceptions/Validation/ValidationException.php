<?php

namespace Modules\Core\Exceptions\Validation;

use Modules\Core\Exceptions\ApiException;
use Modules\Core\Enum\Response\ResponseCode;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException as BaseValidationException;

final class ValidationException extends BaseValidationException implements ApiException
{
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function getSystemCode(): ResponseCode
    {
        return ResponseCode::VALIDATION_ERROR;
    }
}
