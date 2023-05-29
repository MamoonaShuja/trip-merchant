<?php

namespace Modules\Tour\DataTransfer\Requests;

use Illuminate\Http\UploadedFile;
use Modules\Core\DataTransfer\DTO;

class DestinationDTO implements DTO
{
    /**
     * @param string $name
     * @param string $content
     * @param UploadedFile|null $Image
     */
    public function __construct(
        private readonly string $name,
        private readonly string $content,
        private readonly null|UploadedFile $image,
        private readonly null|array $slider,
    ) {}

    /**
     * @param string $name
     * @param string $content
     * @param UploadedFile|null $Image
     * @return static
     */
    public static function create(string $name, string|null $content , null|UploadedFile $image = null , null|array $slider): self
    {
        return new self($name, $content , $image , $slider);
    }

    /**
     * @return string
     */
    public function getName(): string|null
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getContent(): string|null
    {
        return $this->content;
    }

    /**
     * @return UploadedFile|null
     */
    public function getImage(): UploadedFile|null
    {
        return $this->image;
    }

    /**
     * @return array|null
     */
    public function getSlider(): array|null
    {
        return $this->slider;
    }
}
