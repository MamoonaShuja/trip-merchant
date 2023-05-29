<?php

namespace Modules\Tour\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\QuoteRepositoryContract;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourQuote;
use Modules\User\Entities\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class QuoteRepository implements QuoteRepositoryContract
{
    public function __construct(private readonly TourQuote $model) {}

    /**
     * @param string $name
     * @param string $content
     * @param UploadedFile|null $file
     * @return TourQuote
     */
    public function create(User|Auth $objUser , Tour $objTour , City $objCity ,
                           string   $strPassengerNumber,
                           string   $strDate,
                           string   $strDescription,): TourQuote
    {
        $objQuery = $this->model->newQuery();
        $objTourQuote = $objQuery->create([
            'user_id' => $objUser->id,
            'tour_quote_uuid' => Str::uuid(),
            'tour_id' => $objTour->id,
            'city_id' => $objCity->id,
            'passenger_number' => $strPassengerNumber,
            'date' => $strDate,
            'description' => $strDescription,
        ]);
        return $objTourQuote;
    }


    /**
     * @return Collection|null
     */
    public function getQuotes(): Collection|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->latest()->get();
    }

    /**
     * @param string $id
     * @return TourQuote|null
     */
    public function findById(string $id): TourQuote|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->find($id);
    }

    public function findByUuid(string $id): TourQuote|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereTourQuoteUuid($id)->first();
    }

    /**
     * @param TourQuote $tourQuote
     * @return bool
     */
    public function deleteTourQuote(TourQuote $tourQuote): bool
    {
        return $tourQuote->delete();
    }

    /**
     * @param TourQuote $objTourQuote
     * @param string|null $strStatus
     * @return TourQuote
     */
    public function updateTourQuote(TourQuote $objTourQuote, string|null $strStatus = null ,string|null $strNote = null): TourQuote
    {
        if (is_string($strStatus) && $objTourQuote->status !== $strStatus)
            $objTourQuote->status = $strStatus;
        if (is_string($strNote) && $objTourQuote->notes !== $strNote)
            $objTourQuote->note = $strNote;
        $objTourQuote->update();
        return $objTourQuote;
    }
}
