<?php

namespace Modules\Organizer\Repositories;

use Illuminate\Support\Str;
use Modules\Organizer\Contracts\Repositories\OrganizerSliderRepositoryContract;
use Modules\Organizer\Entities\OrganizationSlider;

final class OrganizerSliderRepository implements OrganizerSliderRepositoryContract
{
    public function __construct(private readonly OrganizationSlider $model) {}

    public function addSlider(string $strTitle, string $strDescription,): OrganizationSlider
    {
        $objOrganizationSlider = new OrganizationSlider([
            'title' => $strTitle,
            'description' => $strDescription,
            'organization_slider_uuid' => Str::uuid()
        ]);
        return $objOrganizationSlider;
    }

    public function updateSlider(OrganizationSlider $objOrganizationSlider, string $strTitle, string $strDescription): OrganizationSlider
    {
        if (is_string($strTitle) && $objOrganizationSlider->title !== $strTitle)
            $objOrganizationSlider->title = $strTitle;
        if (is_string($strDescription) && $objOrganizationSlider->description !== $strDescription)
            $objOrganizationSlider->description = $strDescription;
        $objOrganizationSlider->update();
        return $objOrganizationSlider;
    }

    public function getSliderByUUid(string|null $strUuid): OrganizationSlider|null
    {
        if(is_null($strUuid))
            return null;
        $objQuery = $this->model->newQuery();
        return $objQuery->whereOrganizationSliderUuid($strUuid)->first();
    }

    public function deleteSlider(OrganizationSlider $objOrganizationSlider): bool
    {
        $objOrganizationSlider->medially()->delete();
        return $objOrganizationSlider->delete();
    }
}
