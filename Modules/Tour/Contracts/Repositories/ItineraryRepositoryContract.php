<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourItinerary;
use PhpParser\Node\Expr\AssignOp\Mod;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ItineraryRepositoryContract
{
    /**
     * @param Tour $objTour
     * @param string|null $strDay
     * @param string|null $strHotelNames
     * @param string|null $strDescription
     * @param string|null $strMeals
     * @param string|null $strOptional
     * @return TourItinerary
     */
    public function create(
        string|null $strDay,
        string|null $strHotelNames,
        string|null $strDescription,
        string|null $strMeals,
        string|null $strOptional,
      ): TourItinerary;

    /**
     * @param int|null $id
     * @return Model|TourItinerary|null
     */
    public function findById(int|null $id): Model|TourItinerary|null;

    /**
     * @param Tour $tour
     * @return bool
     */
    public function delete(TourItinerary $tour): bool;

    /**
     * @param TourItinerary $objTour
     * @param string|null $strDay
     * @param string|null $strHotelNames
     * @param string|null $strDescription
     * @param string|null $strMeals
     * @param string|null $strOptional
     * @return TourItinerary
     */
    public function update(
        TourItinerary $objTour,
        string|null $strDay,
        string|null $strHotelNames,
        string|null $strDescription,
        string|null $strMeals,
        string|null $strOptional,
    ): TourItinerary;
}
