<?php

namespace Modules\Organizer\DataTransfer\Requests;

use Illuminate\Http\UploadedFile;
use Modules\Core\DataTransfer\DTO;

final class UpdateSliderDTO implements DTO
{
    /**
     * @param array $meta_key
     * @param array $meta_value
     */
    public function __construct(
        private readonly string $title,
        private readonly string $description,
        private readonly UploadedFile|null $file,
    ) { }

    /**
     * @param array $meta_key
     * @param array $meta_value
     * @return static
     */
    public static function create(
        string $title,
        string $description,
        UploadedFile|null $file,
    ): self {
        return new self($title , $description , $file);
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return UploadedFile|null
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }


}
