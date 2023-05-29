<?php

namespace Modules\User\Contracts\Services;

use Modules\User\DataTransfer\Requests\SubscriberDTO;
use Modules\User\Entities\Subscriber;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Modules\User\DataTransfer\Requests\SignUpDTO;
use \Illuminate\Database\Eloquent\Collection;

interface SubscriberContract {
    /**
     * @param User $objOrganization`12
     * @param SubscriberDTO $subscriberDTO
     * @return Subscriber
     */
    public function create(User $objOrganization , SubscriberDTO $subscriberDTO): Subscriber;

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
     * @param string $userType
     * @return Collection|null
     */
    public function getAll(User|null $organization):?Collection;

    /**
     * @param Subscriber $subscriber
     * @return bool
     */
    public function delete(Subscriber $subscriber):bool;
}
