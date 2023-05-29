<?php

namespace Modules\User\Exceptions;

use Modules\Core\Exceptions\ApiException;
use Modules\Core\Enum\Response\ResponseCode;

class PasswordMismatchException extends \Exception implements ApiException
{
    public function __construct()
    {
        parent::__construct(message: "Your Current Password Doesn't Match With Provided.");
    }

    public function getSystemCode(): ResponseCode
    {
        return ResponseCode::PASSWORD_MISMATCH_ERROR;
    }
}
