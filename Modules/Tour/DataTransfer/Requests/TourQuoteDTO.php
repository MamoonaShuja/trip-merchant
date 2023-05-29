<?php

namespace Modules\Tour\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

class TourQuoteDTO implements DTO
{
    /**
     * @param string|null $slug
     * @param string|null $departure_city
     * @param string|null $passenger_number
     * @param string|null $date
     * @param string|null $description
     * @param string|null $status
     * @param string|null $notes
     */
    public function __construct(
        private readonly null|string $slug,
        private readonly null|string $departure_city,
        private readonly null|string $passenger_number,
        private readonly null|string $date,
        private readonly null|string $description,
        private readonly null|string $status,
        private readonly null|string $notes,
    ) {}

    /**
     * @param string $name
     * @return static
     */
    public static function create(
        null|string $slug,
        null|string $departure_city,
        null|string $passenger_number,
        null|string $date,
        null|string $description,
        null|string $status,
        null|string $notes,
    ): self
    {
        return new self($slug , $departure_city , $passenger_number , $date , $description , $status , $notes);
    }

    /**
     * @return string|null
     */
    public function getSlug(): string|null
    {
        return $this->slug;
    }

    /**
     * @return string|null
     */
    public function getDepartureCity(): string|null
    {
        return $this->departure_city;
    }

    /**
     * @return string|null
     */
    public function getPassengerNumber(): string|null
    {
        return $this->passenger_number;
    }

    /**
     * @return string|null
     */
    public function getDate(): string|null
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getDescription(): string|null
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

}
