<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourDepartureDate;

interface DepartureDateRepositoryContract
{
    /**
     * @param string $strYear
     * @param string $strStartDate
     * @param string $strEndDate
     * @param string $strAvailability
     * @param string $strPrice
     * @return TourDepartureDate
     */
    public function create(
        string $strYear,
        string $strStartDate,
        string $strEndDate,
        string $strAvailability,
        string $strPrice,
      ): TourDepartureDate;

    /**
     * @param int $id
     * @return Model|TourDepartureDate|null
     */
    public function findById(int|null $id): Model|TourDepartureDate|null;

    /**
     * @param TourDepartureDate $tour
     * @return bool
     */
    public function delete(TourDepartureDate $tour): bool;

    /**
     * @param Tour $objTour
     * @param string $year
     * @param string $start_date
     * @param string $end_date
     * @param string $availability
     * @param string $price
     * @return TourDepartureDate
     */
    public function update(
        TourDepartureDate $objTourDepartureDate,
        string $strYear,
        string $strStartDate,
        string $strEndDate,
        string $strAvailability,
        string $strPrice,
    ): TourDepartureDate;
}
