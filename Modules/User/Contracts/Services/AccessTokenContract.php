<?php

namespace Modules\User\Contracts\Services;

use Modules\User\Entities\User;
use Illuminate\Support\Collection;
use Laravel\Sanctum\PersonalAccessToken;

interface AccessTokenContract
{
    /**
     * @param User $objUser
     * @return PersonalAccessToken
     */
    public function getCurrentToken(User $objUser): PersonalAccessToken;

    /**
     * @param User $objUser
     * @return Collection<int, PersonalAccessToken>
     */
    public function getUsersTokens(User $objUser): Collection;

    /**
     * @param User $objUser
     * @return string
     */
    public function createAuthToken(User $objUser): string;

    /**
     * @param PersonalAccessToken $objToken
     * @return bool
     */
    public function revokeToken(PersonalAccessToken $objToken): bool;
}
