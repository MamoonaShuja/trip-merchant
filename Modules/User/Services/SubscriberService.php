<?php

namespace Modules\User\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Contracts\Repositories\SubscriberRepositoryContract;
use Modules\User\Contracts\Services\SubscriberContract;
use Modules\User\DataTransfer\Requests\SubscriberDTO;
use Modules\User\Entities\Subscriber;
use Modules\User\Entities\User;

final class SubscriberService implements SubscriberContract
{
    /**
     * @param SubscriberRepositoryContract $objSubscriberRepository
     */
    public function __construct(
        //Repositories
        private readonly SubscriberRepositoryContract $objSubscriberRepository,
    ) {}

    /**
     * @param SubscriberDTO $subscriberDTO
     * @param User $organization
     * @return Subscriber
     */
    public function create(User $organization , SubscriberDTO $subscriberDTO): Subscriber
    {
        return $this->objSubscriberRepository->create(
            $organization,
            $subscriberDTO->getEmail(),
        );
    }

    /**
     * @param string $strEmail
     * @return Subscriber|null
     */
    public function findByEmail(string $strEmail): Subscriber|null
    {
        return $this->objSubscriberRepository->findByEmail($strEmail);
    }

    /**
     * @param string $id
     * @return Subscriber|null
     */
    public function findByUuid(string $id): Subscriber|null
    {
        return $this->objSubscriberRepository->findByUuid($id);
    }

    /**
     * @param string|null $organization_uuid
     * @return Collection|null
     */
    public function getAll(User|null $organization): null|Collection
    {
        return $this->objSubscriberRepository->getAll($organization);
    }

    /**
     * @param Subscriber $subscriber
     * @return bool
     */
    public function delete(Subscriber $subscriber): bool
    {
        return $this->objSubscriberRepository->delete($subscriber);
    }
}
