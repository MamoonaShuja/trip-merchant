<?php

namespace Modules\User\Observers;

use Modules\User\Entities\User;
use JetBrains\PhpStorm\NoReturn;
use Modules\Core\Contracts\Services\Cache\Cache;

final class UserObserver
{
    public bool $afterCommit = true;

    /**
     * @param Cache $cache
     */
    public function __construct(private readonly Cache $cache) {}

    /**
     * @param User $objUser
     * @return void
     */
    #[NoReturn]
    public function created(User $objUser): void
    {
       $this->cache->set("User.{$objUser->id}", $objUser);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param User $objUser
     * @return void
     */
    public function updated(User $objUser): void
    {
        $this->cache->set("User.{$objUser->id}", $objUser);
    }
}
