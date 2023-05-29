<?php

namespace Modules\Core\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;
use Modules\Core\Enum\Security\OtpTypes;

final class CreateOtpDTO implements DTO
{
    public function __construct(private readonly OtpTypes $type) { }

    public static function create(OtpTypes $type): self
    {
        return new self($type);
    }

    /**
     * @return OtpTypes
     */
    public function getType(): OtpTypes
    {
        return $this->type;
    }
}
