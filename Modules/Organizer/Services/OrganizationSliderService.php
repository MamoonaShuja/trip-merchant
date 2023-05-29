<?php

namespace Modules\Organizer\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Organizer\DataTransfer\Requests\UpdateSettingsDTO;
use Modules\Organizer\DataTransfer\Requests\UpdateSliderDTO;
use Modules\Organizer\Contracts\Repositories\OrganizerSliderRepositoryContract;
use Modules\Organizer\Contracts\Repositories\SettingsRepositoryContract;
use Modules\Organizer\Contracts\Services\OrganizationSliderContract;
use Modules\Organizer\Entities\OrganizationSlider;
use Modules\Organizer\Entities\Setting;
use Modules\Tour\Enum\MediaTypes;

final class OrganizationSliderService implements OrganizationSliderContract
{
    /**
     * @param OrganizerSliderRepositoryContract $objOrganizerSliderRepository
     */
    public function __construct(
        //Repositories
        private readonly OrganizerSliderRepositoryContract $objOrganizerSliderRepository,
        private readonly SettingsRepositoryContract $objSettingsRepository,

    ) {}


    /**
     * @param Setting $objSetting
     * @param UpdateSettingsDTO $objUpdateSettingsDTO
     * @return Collection|null
     */
    public function addSlider(Setting $objSetting , UpdateSettingsDTO $objUpdateSettingsDTO): Collection|null
    {
        $existingOrganizerSliderIds = $objSetting->sliders()->pluck('organization_slider_uuid')->toArray();
        $incomingOrganizerSliderIds = [];
        $organizerSlider = $objUpdateSettingsDTO->getSliders();
        $objNewOrganizerSlider = [];
        foreach ($organizerSlider as $index => $item) {
            $incomingOrganizerSliderIds[] = $objUpdateSettingsDTO->getSliderUuid($index);
            $objOrganizerSlider = $this->objOrganizerSliderRepository->getSliderByUUid($objUpdateSettingsDTO->getSliderUuid($index));
            if(!is_null($objOrganizerSlider)){
                $objCabinDeckUpdate = $this->objOrganizerSliderRepository->updateSlider(
                    $objOrganizerSlider,
                    $objUpdateSettingsDTO->getSliderTitle($index),
                    $objUpdateSettingsDTO->getSliderDescription($index),
                );
                if(!is_null($objUpdateSettingsDTO->getSliderFile($index))){
                    $objOrganizerSlider->detachMedia(MediaTypes::SLIDER->value);
                    $objCabinDeckUpdate->saveSlider($objUpdateSettingsDTO->getSliderFile($index));
                }
            }else{
                $objNewOrganizerSlider[] = $this->objOrganizerSliderRepository->addSlider(
                    $objUpdateSettingsDTO->getSliderTitle($index),
                    $objUpdateSettingsDTO->getSliderDescription($index),
                );
            }
        }
        if (!is_null($objNewOrganizerSlider)) {
            $objOrganizerSliderNew = $this->objSettingsRepository->saveSliders($objSetting, $objNewOrganizerSlider);
            $this->saveFiles($objOrganizerSliderNew , $objUpdateSettingsDTO);
        }
        $OrganizerSliderToDelete = array_diff($existingOrganizerSliderIds, $incomingOrganizerSliderIds);
        $this->deleteSliders($OrganizerSliderToDelete);
        return $objSetting->sliders;
    }

    /**
     * @param Collection $savedSliders
     * @param UpdateSettingsDTO $objUpdateSettingsDTO
     * @return void
     */
    public function saveFiles(Collection $savedSliders , UpdateSettingsDTO $objUpdateSettingsDTO){
        foreach ($savedSliders as $index => $savedSlider){
            if(!is_null($objUpdateSettingsDTO->getSliderFile($index)))
                $savedSlider->saveSlider($objUpdateSettingsDTO->getSliderFile($index));
        }
    }


    /**
     * @param OrganizationSlider $objOrganizationSlider
     * @param UpdateSliderDTO $objUpdateSliderDTO
     * @return OrganizationSlider
     */
    public function updateSlider(OrganizationSlider $objOrganizationSlider, UpdateSliderDTO $objUpdateSliderDTO): OrganizationSlider
    {
       $objOrganizationSlider = $this->objOrganizerSliderRepository->updateSlider($objOrganizationSlider , $objUpdateSliderDTO->getTitle() , $objUpdateSliderDTO->getDescription());
       if(!is_null($objUpdateSliderDTO->getFile())){
           $objOrganizationSlider->detachMedia(MediaTypes::SLIDER->value);
           $objOrganizationSlider->saveSlider($objUpdateSliderDTO->getFile());
       }
       return $objOrganizationSlider;
    }

    /**
     * @param string $strUuid
     * @return OrganizationSlider
     */
    public function getSliderByUuid(string $strUuid): OrganizationSlider
    {
        return $this->objOrganizerSliderRepository->getSliderByUUid($strUuid);
    }

    /**
     * @param OrganizationSlider $objOrganizationSlider
     * @return bool
     */
    public function deleteSlider(OrganizationSlider $objOrganizationSlider): bool{
        return $this->objOrganizerSliderRepository->deleteSlider($objOrganizationSlider);
    }

    /**
     * @param array $organizationSliderToDelete
     * @return void
     */
    public function deleteSliders(array $organizationSliderToDelete):void{
        foreach ($organizationSliderToDelete as $organizationSliderToDeleteId){
            $objOrganizationSliderToDelete = $this->objOrganizerSliderRepository->getSliderByUUid($organizationSliderToDeleteId);
            if(!is_null($objOrganizationSliderToDelete))
                $this->deleteSlider($objOrganizationSliderToDelete);
        }
    }
}
