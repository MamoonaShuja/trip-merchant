<?php

namespace Modules\Core\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\Entities\ScheduleDemo;
use Modules\Core\Http\Requests\ScheduleDemoRequest;

interface ScheduleDemoContract
{


    /**
     * @param ScheduleDemoRequest $demoRequest
     * @return ScheduleDemo|null
     */
    public function create(ScheduleDemoRequest $demoRequest): ScheduleDemo|null;


    /**
     * @return LengthAwarePaginator|null
     */
    public function get(): LengthAwarePaginator|null;

    /**
     * @param string $strUuid
     * @return ScheduleDemo|null
     */
    public function findByUuId(string $strUuid): ScheduleDemo|null;


}
