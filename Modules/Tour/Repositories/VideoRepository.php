<?php

namespace Modules\Tour\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\VideoRepositoryContract;
use Modules\Tour\Entities\TourEssentialInfo;
use Modules\Tour\Entities\TourVideo;

class VideoRepository implements VideoRepositoryContract
{
    public function __construct(private readonly TourVideo $model) {}


    /**
     * @param string $strTitle
     * @param string $strDescription
     * @return TourEssentialInfo
     */
    public function create(string $strVideoLink,
    ): TourVideo{
        $objTourVideo = new TourVideo([
            'video_link' => $strVideoLink,
            'tour_video_uuid' => Str::uuid()
        ]);
        return $objTourVideo;
    }

    /**
     * @param int $id
     * @return Model|TourVideo|null
     */
    public function findById(int|null $id): Model|TourVideo|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereTourVideoUuid($id)->first();
    }

    /**
     * @param TourVideo $objTourVideo
     * @return bool
     */
    public function delete(TourVideo $objTourVideo): bool
    {
        return $objTourVideo->delete();
    }

    /**
     * @param TourEssentialInfo $objTourEssentialInfo
     * @param string $strTitle
     * @param string $strDescription
     * @return TourEssentialInfo
     */
    public function update(TourVideo $objTourVideo,
                           string $strVideoLink,
    ): TourVideo
    {
        if (is_string($strVideoLink) && $objTourVideo->video_link !== $strVideoLink)
            $objTourVideo->video_link = $strVideoLink;
        $objTourVideo->update();
        return $objTourVideo;
    }
}
