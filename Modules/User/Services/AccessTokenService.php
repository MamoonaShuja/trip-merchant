<?php

namespace Modules\User\Services;

use Modules\User\Entities\User;
use Illuminate\Support\Collection;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\Core\Contracts\Http\UserAgentContract;
use Modules\User\Contracts\Services\AccessTokenContract;

final class AccessTokenService implements AccessTokenContract
{
    public function __construct(
        private readonly UserAgentContract $objUserAgentService
    ) {}

    public function createAuthToken(User $objUser): string
    {
        $strTokenName = $this->objUserAgentService->getSessionPlatform();

        return $objUser->createToken($strTokenName)->plainTextToken;
    }

    public function revokeToken(PersonalAccessToken $objToken): bool
    {
        return $objToken->delete();
    }

    public function getCurrentToken(User $objUser): PersonalAccessToken
    {
        /** @var PersonalAccessToken $objToken */
        $objToken = $objUser->currentAccessToken();

        return $objToken;
    }

    public function getUsersTokens(User $objUser): Collection
    {
        return $objUser->tokens;
    }
}
