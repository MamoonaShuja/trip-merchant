<?php

namespace Modules\Tour\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\DepartureDateRepositoryContract;
use Modules\Tour\Entities\TourDepartureDate;

class DepartureDateRepository implements DepartureDateRepositoryContract
{
    public function __construct(private readonly TourDepartureDate $model) {}

    /**
     * @param string $strYear
     * @param string $strStartDate
     * @param string $strEndDate
     * @param string $strAvailability
     * @param string $strPrice
     * @return TourDepartureDate
     */
    public function create(string $strYear,
                           string $strStartDate,
                           string $strEndDate,
                           string $strAvailability,
                           string $strPrice): TourDepartureDate
    {
        $departureDate = new TourDepartureDate([
            'year' => $strYear,
            'start_date' => $strStartDate,
            'end_date' => $strEndDate,
            'availability' => $strAvailability,
            'price' => $strPrice,
            "tour_departure_uuid" => Str::uuid()
        ]);
        return $departureDate;
     }

    /**
     * @param int $id
     * @return Model|TourDepartureDate|null
     */
    public function findById(int|null $id): Model|TourDepartureDate|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->find($id);
    }

    /**
     * @param TourDepartureDate $objTourDepartureDate
     * @return bool
     */
    public function delete(TourDepartureDate $objTourDepartureDate): bool
    {
        return $objTourDepartureDate->delete();
    }

    /**
     * @param TourDepartureDate $objTourDepartureDate
     * @param string $strYear
     * @param string $strStartDate
     * @param string $strEndDate
     * @param string $strAvailability
     * @param string $strPrice
     * @return TourDepartureDate
     */
    public function update(TourDepartureDate $objTourDepartureDate , string $strYear,
                           string            $strStartDate,
                           string            $strEndDate,
                           string            $strAvailability,
                           string            $strPrice,): TourDepartureDate
    {
        if (is_string($strYear) && $objTourDepartureDate->year !== $strYear) {
            $objTourDepartureDate->year = $strYear;
        }
        if (is_string($strStartDate) && $objTourDepartureDate->start_date !== $strStartDate) {
            $objTourDepartureDate->start_date = $strStartDate;
        }
        if (is_string($strEndDate) && $objTourDepartureDate->end_date !== $strEndDate) {
            $objTourDepartureDate->end_date = $strEndDate;
        }
        if (is_string($strAvailability) && $objTourDepartureDate->availability !== $strAvailability) {
            $objTourDepartureDate->availability = $strAvailability;
        }
        if (is_string($strPrice) && $objTourDepartureDate->price !== $strPrice) {
            $objTourDepartureDate->price = $strPrice;
        }
        $objTourDepartureDate->save();
        return $objTourDepartureDate;
    }
}
