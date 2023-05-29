<?php

namespace Modules\Tour\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\CabinDeckRepositoryContract;
use Modules\Tour\Entities\TourCabinDeck;

class CabinDeckRepository implements CabinDeckRepositoryContract
{
    public function __construct(private readonly TourCabinDeck $model) {}


    /**
     * @param string $strTitle
     * @param string $strDescription
     * @return TourCabinDeck
     */
    public function create(string $strTitle,
                           string $strDescription,
    ): TourCabinDeck{
        $objTourCabinDeck = new TourCabinDeck([
            'title' => $strTitle,
            'description' => $strDescription,
            'tour_cabin_deck_uuid' => Str::uuid()
        ]);
        return $objTourCabinDeck;
    }

    /**
     * @param int $id
     * @return Model|TourCabinDeck|null
     */
    public function findById(int|null $id): Model|TourCabinDeck|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereTourCabinDeckUuid($id)->first();
    }

    /**
     * @param TourCabinDeck $objTourCabinDeck
     * @return bool
     */
    public function delete(TourCabinDeck $objTourCabinDeck): bool
    {
        $objTourCabinDeck->medially()->delete();
        return $objTourCabinDeck->delete();
    }

    /**
     * @param TourCabinDeck $objTourCabinDeck
     * @param string $strTitle
     * @param string $strDescription
     * @return TourCabinDeck
     */
    public function update(TourCabinDeck $objTourCabinDeck,
                           string $strTitle,
                           string $strDescription,
    ): TourCabinDeck
    {
        if (is_string($strTitle) && $objTourCabinDeck->title !== $strTitle)
            $objTourCabinDeck->title = $strTitle;
        if (is_string($strDescription) && $objTourCabinDeck->description !== $strDescription)
            $objTourCabinDeck->description = $strDescription;
        $objTourCabinDeck->update();
        return $objTourCabinDeck;
    }
}




