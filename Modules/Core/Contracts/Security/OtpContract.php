<?php

namespace Modules\Core\Contracts\Security;

use Modules\User\Entities\User;
use Modules\Core\Entities\OtpCode;
use Modules\Core\Enum\Security\OtpTypes;

interface OtpContract {
    public function findActiveByType(User $objUser, OtpTypes $objType): ?OtpCode;
    public function create(User $objUser, OtpTypes $objType): OtpCode;

    public function verify(User $objUser, string $strCode, OtpTypes $objType): void;
}
