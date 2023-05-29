<?php

namespace Modules\User\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\Subscriber;
use Modules\User\Entities\User;

interface SubscriberRepositoryContract
{
    /**
     * @param User $organization
     * @param string $email
     * @return Subscriber
     */
    public function create(
        User $organization,
        string $email,
      ): Subscriber;

    /**
     * @param string $strEmail
     * @return Subscriber|null
     */
    public function findByEmail(string $strEmail): Subscriber|null;

    /**
     * @param string $id
     * @return Subscriber|null
     */
    public function findByUuid(string $id): Subscriber|null;

    /**
     * @param int|null $organization
     * @return Collection|null
     */
    public function getAll(User|null $organization): null|Collection;

    /**
     * @param Subscriber $subscriber
     * @return bool
     */
    public function delete(Subscriber $subscriber): bool;


}
