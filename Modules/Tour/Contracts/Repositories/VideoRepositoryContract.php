<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourVideo;

interface VideoRepositoryContract
{
    /**
     * @param Tour $objTour
     * @param string $video_link
     * @return TourVideo
     */
    public function create(
        string $video_link,
      ): TourVideo;

    /**
     * @param int $id
     * @return Model|TourVideo|null
     */
    public function findById(int $id): Model|TourVideo|null;

    /**
     * @param TourVideo $tour
     * @return bool
     */
    public function delete(TourVideo $tour): bool;

    /**
     * @param Tour $objTour
     * @param string $video_link
     * @return TourVideo
     */
    public function update(
        TourVideo $objTourVideo,
        string $video_link,
    ): TourVideo;
}
