<?php

namespace Modules\Tour\DataTransfer\Requests;

use Illuminate\Http\UploadedFile;
use Modules\Core\DataTransfer\DTO;

class FileUploadDTO implements DTO
{
    /**
     * @param UploadedFile $uploadedFile
     */
    public function __construct(
        private readonly UploadedFile $uploadedFile,
    ) {}
    public static function create(UploadedFile $uploadedFile): self
    {
        return new self($uploadedFile);
    }
    /**
     * @return UploadedFile
     */
    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }

}
