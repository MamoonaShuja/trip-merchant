<?php

namespace Modules\Tour\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

class FilesUploadDTO implements DTO
{
    /**
     * @param array $uploadedFiles
     */
    public function __construct(
        private readonly array $uploadedFiles,
    ) {}

    /**
     * @param array $uploadedFile
     * @return static
     */
    public static function create(array $uploadedFile): self
    {
        return new self($uploadedFile);
    }

    /**
     * @return array
     */
    public function getUploadedFiles(): array
    {
        return $this->uploadedFiles;
    }

}
