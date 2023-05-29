<?php

namespace Modules\Tour\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

class GuidedTourFilterDTO implements DTO
{
    /**
     * @param string $name
     */
    public function __construct(
        private readonly string|null $supplier_id,
        private readonly string|null $destination_id,
        private readonly string|null $start_date,
        private readonly string|null $end_date,
        private readonly string|null $start_price,
        private readonly string|null $end_price,
        private readonly string|null $itinerary_name,
        private readonly string|null $travel_style_id,
    ) {}

    /**
     * @param string $name
     * @return static
     */
    public static function create(
        string|null $supplier_id,
        string|null $destination_id,
        string|null $start_date,
        string|null $end_date,
        string|null $start_price,
        string|null $end_price,
        string|null $itinerary_name,
        string|null $travel_style_id

    ): self
    {
        return new self($supplier_id,
            $destination_id,
            $start_date,
            $end_date,
            $start_price,
            $end_price,
            $itinerary_name,
            $travel_style_id);
    }


    /**
     * @return string
     */
    public function getDestinationId(): string|null
    {
        return $this->destination_id;
    }


    /**
     * @return string|null
     */
    public function getSupplierId(): string|null
    {
        return $this->supplier_id;
    }

    /**
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->start_date;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->end_date;
    }

    /**
     * @return string|null
     */
    public function getItineraryName(): ?string
    {
        return $this->itinerary_name;
    }

    /**
     * @return string|null
     */
    public function getStartPrice(): ?string
    {
        return $this->start_price;
    }

    /**
     * @return string|null
     */
    public function getEndPrice(): ?string
    {
        return $this->end_price;
    }
    public function getTravelStyleId(): ?string
    {
        return $this->travel_style_id;
    }

}
