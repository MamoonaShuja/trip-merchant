<?php

namespace Modules\Core\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\Contracts\Repositories\ScheduleDemoRepositoryContract;
use Modules\Core\Contracts\Services\ScheduleDemoContract;
use Modules\Core\Entities\Role;
use Modules\Core\Entities\ScheduleDemo;
use Modules\Core\Http\Requests\ScheduleDemoRequest;
use Modules\Core\Notifications\EmailNotification;
use Modules\User\Enum\UserType;

class ScheduleDemoService implements ScheduleDemoContract
{
    public function __construct(
        private readonly ScheduleDemoRepositoryContract $objScheduleDemoRepository,

    )
    {
    }

    public function create(ScheduleDemoRequest $demoRequest): ScheduleDemo|null
    {
        $scheduleDemo = $this->objScheduleDemoRepository->create($demoRequest->first_name, $demoRequest->last_name, $demoRequest->email, $demoRequest->type, $demoRequest->message);
        $subject = "New Demo request";
        $message = "<strong>First Name: </strong>" . $scheduleDemo->first_name . "<br>" .
            "<strong>Last Name: </strong>" . $scheduleDemo->last_name . "<br>" .
            "<strong>Email Address: </strong>" . $scheduleDemo->email . " <br>" .
            "<strong>Type of Partnership Interested In: </strong>" . $scheduleDemo->type . " <br>" .
            "<strong>Message: </strong><br>" . $scheduleDemo->message;
        $role = Role::where('name', UserType::ADMIN->value)->first();
        $admin = $role->users->first();
        $admin->notify(new EmailNotification($subject, $message));

        return $scheduleDemo;

    }


    /**
     * @return LengthAwarePaginator|null
     */
    public function get(): LengthAwarePaginator|null
    {
        return $this->objScheduleDemoRepository->getScheduleDemos();
    }

    public function findByUuId(string $strUuid): ScheduleDemo|null
    {
        return $this->objScheduleDemoRepository->findByUuid($strUuid);
    }


}
