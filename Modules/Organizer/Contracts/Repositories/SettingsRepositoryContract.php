<?php

namespace Modules\Organizer\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\Organizer\Entities\Setting;
use Modules\User\Entities\User;

interface SettingsRepositoryContract
{
    /**
     * @param User|Auth $objOrganization
     * @param array $arrMetaData
     * @return Collection|null
     */
    public function updateSettings(User|Auth $objOrganization, array $arrMetaData): Collection|null;

    /**
     * @param User|Auth $objOrganization
     * @return Collection|null
     */
    public function create(User|Auth $objOrganization): Setting;

    /**
     * @param Setting $objSetting
     * @param array $objSliders
     * @return Collection|null
     */
    public function saveSliders(Setting $objSetting, array $objSliders): Collection|null;

}
