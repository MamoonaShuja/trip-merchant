<?php

namespace Modules\Core\Exceptions;

use Modules\Core\Enum\Response\ResponseCode;

interface ApiException extends \Throwable
{
    public function getSystemCode(): ResponseCode;
}
