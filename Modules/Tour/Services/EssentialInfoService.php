<?php

namespace Modules\Tour\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\Contracts\Repositories\EssentialInfoRepositoryContract;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Services\EssentialInfoContract;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

class EssentialInfoService implements EssentialInfoContract
{
    public function __construct(
        //Repositories
        private readonly TourRepositoryContract $objTourRepository,
        private readonly EssentialInfoRepositoryContract $objEssentialInfoRepository,
    ) {}

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveEssentialInfos(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection{
        $objEssentialInfos = [];
        $essentialInfo = $objTourDTO->getEssentialInfo();
        foreach ($essentialInfo as $index => $item) {
            $objEssentialInfo = $this->objEssentialInfoRepository->create(
                $objTourDTO->getEssentialInfoTitle($index),
                $objTourDTO->getEssentialInfoDescription($index),
            );
            $objEssentialInfos[] = $objEssentialInfo;
        }
        $savedEssentialInfos = $this->objTourRepository->saveEssentialInfos($objTour , $objEssentialInfos);
        $this->savePdfs($savedEssentialInfos , $objTourDTO);
        return $savedEssentialInfos;
    }

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateEssentialInfos(Tour $objTour , TourDTO $objTourDTO):Collection
    {
        $existingEssentialInfoIds = $objTour->essentialInfos()->pluck('id')->toArray();
        $incomingEssentialInfoIds = [];
        $essentialInfos = $objTourDTO->getEssentialInfo();
        $objNewEssentialInfos = [];
        foreach ($essentialInfos as $index => $item) {
            $incomingEssentialInfoIds[] = $objTourDTO->getEssentialInfoId($index);
            $objEssentialInfo = $this->objEssentialInfoRepository->findById($objTourDTO->getEssentialInfoId($index));
            if(!is_null($objEssentialInfo)){
                $objEssentialInfoUpdate = $this->objEssentialInfoRepository->update(
                    $objEssentialInfo,
                    $objTourDTO->getEssentialInfoTitle($index),
                    $objTourDTO->getEssentialInfoDescription($index),
                );
                if(!is_null($objEssentialInfoUpdate)){
                    $objEssentialInfoUpdate->savePdf($objTourDTO->getEssentialInfoPdf($index));
                }
            }else{
                $objEssentialInfoNew = $this->objEssentialInfoRepository->create(
                    $objTourDTO->getEssentialInfoTitle($index),
                    $objTourDTO->getEssentialInfoDescription($index),
                );
                $objNewEssentialInfos[] = $objEssentialInfoNew;
            }
        }
        if (!is_null($objNewEssentialInfos)) {
            $savedEssentialInfos = $this->objTourRepository->saveEssentialInfos($objTour, $objNewEssentialInfos);
            $this->savePdfs($savedEssentialInfos , $objTourDTO);
        }
        $essentialInfosToDelete = array_diff($existingEssentialInfoIds, $incomingEssentialInfoIds);
        $this->deleteEssentialInfos($essentialInfosToDelete);
        return $objTour->essentialInfos;
    }

    /**
     * @param array $essentialInfosToDelete
     * @return void
     */
    public function deleteEssentialInfos(array $essentialInfosToDelete):void{
        foreach ($essentialInfosToDelete as $essentialInfoId){
            $objEssentialInfoDelete = $this->objEssentialInfoRepository->findById($essentialInfoId);
            if(!is_null($objEssentialInfoDelete))
                $this->objEssentialInfoRepository->delete($objEssentialInfoDelete);
        }
    }

    /**
     * @param Collection $savedEssentialInfos
     * @param TourDTO $objTourDTO
     * @return void
     */
    public function savePdfs(Collection $savedEssentialInfos , TourDTO $objTourDTO){
        foreach ($savedEssentialInfos as $index => $savedEssentialInfo){
            if(!is_null($objTourDTO->getEssentialInfoPdf($index)))
                $savedEssentialInfo->savePdf($objTourDTO->getEssentialInfoPdf($index));
        }
    }

}
