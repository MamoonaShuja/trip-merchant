<?php

namespace Modules\Tour\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;
use Illuminate\Http\UploadedFile;

class TravelStyleDTO implements DTO
{

    /**
     * @param string $name
     * @param string $content
     * @param bool $is_group
     * @param UploadedFile|null $image
     */
    public function __construct(
        private readonly string $name,
        private readonly string $content,
        private readonly bool $is_group,
        private readonly ?UploadedFile $image,
        private readonly null|array $slider,

    ) {}


    /**
     * @param string $name
     * @param string $content
     * @param bool $is_group
     * @param UploadedFile|null $Image
     * @return static
     */
    public static function create(string $name, string $content , bool $is_group, ?UploadedFile $image = null , array|null $slider): self
    {
        return new self($name, $content, $is_group, $image , $slider);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return UploadedFile
     */
    public function getImage(): null|UploadedFile
    {
        return $this->image;
    }

    /**
     * @return bool
     */
    public function getIsGroup(): bool
    {
        return $this->is_group;
    }

    /**
     * @return array|null
     */
    public function getSlider(): ?array
    {
        return $this->slider;
    }
}
