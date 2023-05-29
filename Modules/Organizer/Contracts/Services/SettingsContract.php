<?php

namespace Modules\Organizer\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Organizer\DataTransfer\Requests\UpdateSettingsDTO;
use Modules\User\Entities\User;

interface SettingsContract {
    /**
     * @param User $objUser
     * @param UpdateSettingsDTO $updateSettingsDTO
     * @return Collection
     */
    public function updateSettings(
        User $objUser,
        UpdateSettingsDTO $updateSettingsDTO,
    ): Collection;

}
