<?php

namespace Modules\Organizer\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Modules\Organizer\Entities\OrganizationSlider;
use Modules\Organizer\Entities\Setting;

interface OrganizerSliderRepositoryContract
{
    /**
     * @param Setting $objSetting
     * @param string $strTitle
     * @param string $strDescription
     * @return OrganizationSlider
     */
    public function addSlider(
                              string $strTitle,
                              string             $strDescription,
    ): OrganizationSlider;

    /**
     * @param OrganizationSlider $objOrganizationSlider
     * @param string $strTitle
     * @param string $strDescription
     * @param UploadedFile $objUploadFile
     * @return Collection|null
     */
    public function updateSlider(OrganizationSlider $objOrganizationSlider ,
                                 string             $strTitle,
                                 string             $strDescription
    ): OrganizationSlider;

    /**
     * @param string $strUuid
     * @return Collection|null
     */
    public function getSliderByUUid(string|null $strUuid): OrganizationSlider|null;

    /**
     * @param OrganizationSlider $objOrganizationSlider
     * @return bool
     */
    public function deleteSlider(OrganizationSlider $objOrganizationSlider): bool;

}
