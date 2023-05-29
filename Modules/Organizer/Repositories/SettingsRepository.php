<?php

namespace Modules\Organizer\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\Organizer\Contracts\Repositories\SettingsRepositoryContract;
use Modules\Organizer\Entities\Setting;
use Modules\Tour\Enum\MediaTypes;
use Modules\User\Entities\User;

final class SettingsRepository implements SettingsRepositoryContract
{
    public function __construct(private readonly Setting $model)
    {
    }

    /**
     * @param User|Auth $objOrganization
     * @param array $arrMetaData
     * @return Collection|null
     */
    public function updateSettings(User|Auth $objOrganization, array $arrMetaData): Collection|null
    {
        foreach ($arrMetaData as $key => $value) {
            $file = "";
            if (is_file($value)) {
                $file = $value;
                $value = $key;
            }
            $objQuery = $this->model->newQuery();
            $meta = $objQuery->updateOrCreate(
                [
                    'meta_key' => $key,
                    'organizer_id' => $objOrganization->id
                ],
                ['meta_value' => $value],
            );
            if (is_file($file) && $key == MediaTypes::LOGO->value) {
                $meta->saveLogo($file);
            }
        }
        return $objOrganization->settings;
    }

    /**
     * @inheritDoc
     */
    public function create(User|Auth $objOrganization): Setting
    {
        $objQuery = $this->model->newQuery();
        $setting = $objQuery->updateOrCreate(
            [
                'meta_key' => "slider",
                'organizer_id' => $objOrganization->id
            ],
            ['meta_value' => "slider"]
        );
        return $setting;
    }

    public function saveSliders(Setting $objSetting, array $objSliders): Collection|null
    {
        $objSetting->sliders()->saveMany($objSliders);
        return $objSetting->sliders()->get();
    }
}
