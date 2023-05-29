<?php

namespace Modules\Organizer\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Organizer\DataTransfer\Requests\UpdateSettingsDTO;
use Modules\Organizer\Contracts\Repositories\SettingsRepositoryContract;
use Modules\Organizer\Contracts\Services\OrganizationSliderContract;
use Modules\Organizer\Contracts\Services\SettingsContract;
use Modules\User\Entities\User;

final class SettingsService implements SettingsContract
{
    /**
     * @param SettingsRepositoryContract $objSettingsRepository
     */
    public function __construct(
        //Repositories
        private readonly SettingsRepositoryContract $objSettingsRepository,
        private readonly OrganizationSliderContract $objOrganizationSliderService,
    )
    {
    }


    /**
     * @param User $objOrganization
     * @param UpdateSettingsDTO $updateSettingsDTO
     * @return Collection
     */
    public function updateSettings(User $objOrganization, UpdateSettingsDTO $updateSettingsDTO): Collection
    {
        if (!empty($updateSettingsDTO->getSliders())) {
            $settings = $this->objSettingsRepository->create($objOrganization);
            $this->objOrganizationSliderService->addSlider($settings, $updateSettingsDTO);
        }
        $meta = $updateSettingsDTO->getMetaKey();
        if (!is_null($updateSettingsDTO->getFilesMeta())) {
            $meta = array_merge($updateSettingsDTO->getMetaKey(), $updateSettingsDTO->getFilesMeta());
        }
        $meta = $this->objSettingsRepository->updateSettings($objOrganization, $meta);
        return $meta;
    }

}
