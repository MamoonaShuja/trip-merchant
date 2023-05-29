<?php

namespace Modules\Admin\DataTransfer\Requests;

use Illuminate\Http\UploadedFile;
use Modules\Core\DataTransfer\DTO;

final class UpdateSettingsDTO implements DTO
{
    /**
     * @param array $meta_key
     * @param array $meta_value
     */
    public function __construct(
        private readonly array $meta_key,
        private readonly array $files_meta,
    ) { }

    /**
     * @param array $meta_key
     * @param array $meta_value
     * @return static
     */
    public static function create(
        array $meta_key,
        array $files_meta
    ): self {
        return new self($meta_key , $files_meta);
    }

    /**
     * @return array
     */
    public function getMetaKey(): array
    {
        return $this->meta_key;
    }

    /**
     * @return array
     */
    public function getFilesMeta(): array
    {
        return $this->files_meta;
    }


}
