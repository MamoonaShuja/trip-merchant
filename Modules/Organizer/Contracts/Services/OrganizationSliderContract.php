<?php

namespace Modules\Organizer\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

use Modules\Organizer\DataTransfer\Requests\UpdateSliderDTO;
use Modules\Organizer\DataTransfer\Requests\UpdateSettingsDTO;
use Modules\Organizer\Entities\OrganizationSlider;
use Modules\Organizer\Entities\Setting;

interface OrganizationSliderContract {
    /**
     * @param Setting $objSetting
     * @param UpdateSettingsDTO $objUpdateSettingsDTO
     * @return Collection|null
     */
    public function addSlider(Setting $objSetting ,  UpdateSettingsDTO $objUpdateSettingsDTO): Collection|null;

    /**
     * @param OrganizationSlider $objOrganizationSlider
     * @param string $strTitle
     * @param string $strDescription
     * @param UploadedFile $objUploadFile
     * @return Collection|null
     */
    public function updateSlider(OrganizationSlider $objOrganizationSlider ,
        UpdateSliderDTO $objUpdateSliderDTO
    ): OrganizationSlider;

    /**
     * @param string $strUuid
     * @return Collection|null
     */
    public function getSliderByUuid(string $strUuid): OrganizationSlider;

    /**
     * @param OrganizationSlider $objOrganizationSlider
     * @return bool
     */
    public function deleteSlider(OrganizationSlider $objOrganizationSlider): bool;

}
