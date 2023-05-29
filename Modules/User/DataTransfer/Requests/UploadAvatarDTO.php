<?php

namespace Modules\User\DataTransfer\Requests;

use Illuminate\Http\UploadedFile;
use Modules\Core\DataTransfer\DTO;

final class UploadAvatarDTO implements DTO
{

    /**
     * @param UploadedFile|null $avatar
     */
    public function __construct(
        private readonly ?UploadedFile $avatar,
    ) { }

    /**
     * @param UploadedFile|null $avatar
     * @return static
     */
    public static function create(
        ?UploadedFile $avatar
    ): self {
        return new self($avatar);
    }

    /**
     * @return UploadedFile|null
     */
    public function getAvatar(): ?UploadedFile
    {
        return $this->avatar;
    }

}
