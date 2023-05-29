<?php

namespace Modules\Organizer\DataTransfer\Requests;

use Illuminate\Http\UploadedFile;
use Modules\Core\DataTransfer\DTO;

final class UpdateSettingsDTO implements DTO
{
    /**
     * @param array $meta_key
     * @param array $files_meta
     * @param array $sliders
     * @param array $slider_files
     */
    public function __construct(
        private readonly array       $meta_key,
        private readonly array|null  $files_meta,
        private readonly array       $sliders,
        private readonly array|null  $slider_files
    )
    {
    }

    /**
     * @param array $meta_key
     * @param array $meta_value
     * @return static
     */
    public static function create(
        array      $meta_key,
        array|null $files_meta,
        array      $sliders,
        array|null $slider_files,
    ): self
    {
        return new self($meta_key, $files_meta, $sliders, $slider_files);
    }

    /**
     * @return array
     */
    public function getMetaKey(): array
    {
        return $this->meta_key;
    }

    /**
     * @return array|null
     */
    public function getSliders(): array|null
    {
        return $this->sliders;
    }

    /**
     * @return array|null
     */
    public function getFilesMeta(): array|null
    {
        return $this->files_meta;
    }


    /**
     * @param int $index
     * @return string|null
     */
    public function getSliderTitle(int $index): string|null
    {
        return array_key_exists("title", $this->getSliders()[$index]) ? $this->getSliders()[$index]['title'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getSliderDescription(int $index): string|null
    {
        return array_key_exists("description", $this->getSliders()[$index]) ? $this->getSliders()[$index]['description'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getSliderUuid(int $index): string|null
    {
        return array_key_exists("uuid", $this->getSliders()[$index]) ? $this->getSliders()[$index]['uuid'] : null;
    }

    /**
     * @return array|null
     */
    public function getSliderFiles(): array|null
    {
        return $this->slider_files;
    }

    /**
     * @param int $index
     * @return UploadedFile|null
     */
    public function getSliderFile(int $index): UploadedFile|null
    {
        return
            !is_null($this->getSliderFiles())
                ? isset($this->getSliderFiles()[$index])
                ? array_key_exists("image",
                    $this->getSliderFiles()[$index]
                )
                    ? $this->getSliderFiles()[$index]['image']
                    : null
                : null
                : null;
    }


}
