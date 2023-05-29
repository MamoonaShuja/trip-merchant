<?php

namespace Modules\Tour\Services;

use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\SupplierApi\Entities\ApiTourId;
use Modules\Tour\Contracts\Repositories\VideoRepositoryContract;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Services\VideoContract;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

class VideoService implements VideoContract
{
    public function __construct(
        //Repositories
        private readonly TourRepositoryContract $objTourRepository,
        private readonly VideoRepositoryContract $objVideoRepository,
    ) {}

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveVideos(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection{
        $objVideos = [];
        $dates = $objTourDTO->getVideos();
        foreach ($dates as $index => $item) {
            $objVideos[] = $this->objVideoRepository->create(
                $objTourDTO->getVideoLink($index),
            );
        }
        return $this->objTourRepository->saveVideos($objTour , $objVideos);
    }
    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateVideos(Tour $objTour , TourDTO $objTourDTO):Collection
    {
        $existingVideoIds = $objTour->videos()->pluck('id')->toArray();
        $incomingVideoIds = [];
        $videos = $objTourDTO->getVideos();
        $objNewVideos = [];
        foreach ($videos as $index => $item) {
            $incomingVideoIds[] = $objTourDTO->getVideoId($index);
            $objVideo = $this->objVideoRepository->findById($objTourDTO->getVideoId($index));
            $objVideo != null ?
                $this->objVideoRepository->update(
                    $objVideo,
                    $objTourDTO->getVideoLink($index)
                ) :
                $objNewVideos[] = $this->objVideoRepository->create(
                    $objTourDTO->getVideoLink($index),
                );
        }
            if (!is_null($objNewVideos))
                $this->objTourRepository->saveVideos($objTour, $objNewVideos);
            $videosToDelete = array_diff($existingVideoIds, $incomingVideoIds);
            $this->deleteVideos($videosToDelete);
        return $objTour->videos;
    }

    /**
     * @param array $videosToDelete
     * @return void
     */
    public function deleteVideos(array $videosToDelete):void{
        foreach ($videosToDelete as $videoId){
            $objVideoDelete = $this->objVideoRepository->findById($videoId);
            if(!is_null($objVideoDelete))
                $this->objVideoRepository->delete($objVideoDelete);
        }
    }
}
