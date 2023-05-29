<?php

namespace Modules\Core\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\Entities\ScheduleDemo;

interface ScheduleDemoRepositoryContract
{

    /**
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $type
     * @param string $message
     * @return ScheduleDemo|null
     */
    public function create(
        string $first_name,
        string $last_name,
        string $email,
        string $type,
        string $message,
    ): ScheduleDemo|null;


    /**
     * @return LengthAwarePaginator|null
     */
    public function getScheduleDemos(): ?LengthAwarePaginator;

    /**
     * @param string $id
     * @return ScheduleDemo|null
     */
    public function findById(string $id): ScheduleDemo|null;


    /**
     * @param string $strUuid
     * @return ScheduleDemo|null
     */
    public function findByUuid(string $strUuid): ScheduleDemo|null;

}
