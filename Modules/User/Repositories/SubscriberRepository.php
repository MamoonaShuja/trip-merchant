<?php

namespace Modules\User\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Contracts\Repositories\SubscriberRepositoryContract;
use Modules\User\Entities\Subscriber;
use Modules\User\Entities\User;

final class SubscriberRepository implements SubscriberRepositoryContract
{
    public function __construct(private readonly Subscriber $model) {}

    /**
     * @param string $strEmail
     * @return User|null
     */
    public function findByEmail(string $strEmail): Subscriber|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereEmail($strEmail)->first();
    }

    /**
     * @param User $organization
     * @param string $email
     * @return Subscriber|Model
     */
    public function create(

        User $organization,
        string $email,
    ): Subscriber {
        $objQuery = $this->model->newQuery();
        return $objQuery->create([
            "email"     => $email,
            "organization_id" => $organization->id,
            "subscribers_uuid" => Str::uuid(),
        ]);
    }


    /**
     * @param string $id
     * @return Subscriber|null
     */
    public function findByUuid(string $id): Subscriber|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereSubscribersUuid($id)->first();
    }

    /**
     * @param string $type
     * @return Collection|null
     */
    public function getAll(User|null $organization): ?Collection
    {
        $objQuery = $this->model->newQuery();
        return is_null($organization) ? $objQuery->latest()->get() : $organization->subscribers;
    }

    /**
     * @param Subscriber $subscriber
     * @return bool
     */
    public function delete(Subscriber $subscriber): bool
    {
        return $subscriber->delete();
    }
}
