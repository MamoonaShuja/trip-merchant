<?php

namespace Modules\Core\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;
use Modules\Core\Enum\Security\OtpTypes;

final class ValidateOtpDTO implements DTO
{
    public function __construct(
        private readonly OtpTypes $type,
        private readonly string $value
    ) { }

    public static function create(
        OtpTypes $type,
        string $value
    ): self {
        return new self($type, $value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return OtpTypes
     */
    public function getType(): OtpTypes
    {
        return $this->type;
    }

}
