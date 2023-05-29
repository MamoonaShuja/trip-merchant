<?php

namespace Modules\Core\Helpers\Filesystem;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Modules\User\Entities\User;
use Illuminate\Contracts\Filesystem\Filesystem;
use Modules\Core\Enum\Filesystem\User as UserPaths;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserFilesystem {
    /**
     * @param User $objUser
     * @return string
     */
    public static function getUserAvatar(User $objUser): string {
        $objFilesystem = resolve(Filesystem::class);
        if (Storage::exists(sprintf(UserPaths::AVATAR->value, $objUser->id))) {
            return $objFilesystem->url(sprintf(UserPaths::AVATAR->value, $objUser->id));
        }
        return $objFilesystem->url(UserPaths::DEFAULT_AVATAR->value);
    }

    /**
     * @param User $objUser
     * @return string
     */
    public static function setUserAvatar(User $objUser , UploadedFile $avatar = null): string {
        $interventionImage = Image::make($avatar)->stream("png", 100);
        return Storage::disk('local')->put(sprintf(UserPaths::AVATAR->value, $objUser->id), $interventionImage, 'public') ? true : false;
    }
}
