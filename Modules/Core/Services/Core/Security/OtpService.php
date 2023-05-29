<?php

namespace Modules\Core\Services\Core\Security;

use Carbon\Carbon;
use Modules\User\Entities\User;
use Modules\Core\Entities\OtpCode;
use Modules\Core\Enum\Security\OtpTypes;
use Modules\Core\Contracts\Security\OtpContract;

class OtpService implements OtpContract {
    /**
     * @param User $objUser
     * @param OtpTypes $objType
     * @return OtpCode
     */
    public function create(User $objUser, OtpTypes $objType): OtpCode {
        return $objUser->verifications()->create([
            "code"       => mt_rand(100000, 999999),
            "type"       => $objType->value,
            "expired_at" => Carbon::now()->addMinutes(30),
        ]);
    }

    public function findActiveByType(User $objUser, OtpTypes $objType): ?OtpCode {
        return $objUser->verifications()->active()->ofType($objType)->notUsed()->first();
    }

    public function verify(User $objUser, string $strCode, OtpTypes $objType): void {
//        $objOtp = $objUser->verifications()->where()
    }
}
