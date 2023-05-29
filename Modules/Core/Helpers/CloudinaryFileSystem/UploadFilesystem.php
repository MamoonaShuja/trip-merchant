<?php
namespace Modules\Core\Helpers\CloudinaryFileSystem;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Enum\MediaTypes;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFilesystem {
    /**
     * @param Tour $objTravelStyle
     * @return string|null
     */
    public static function uploadImage(Object $obj , string $strFolderPath , string $strType, UploadedFile|string $image = null): bool {
        try {
            $options = [
                "cloud_name" => env("CLOUDINARY_CLOUD_NAME"),
                "folder" => sprintf($strFolderPath, $obj->id),
                "timeout" => 6000000,
            ];

            if(is_string($image)) {
                // If $image is a string (i.e. URL), set the public_id to the filename without extension
                $options["public_id"] = pathinfo(parse_url($image, PHP_URL_PATH), PATHINFO_FILENAME);
                $obj->attachMedia($image, $strType, $options);
            } elseif($image instanceof UploadedFile) {
                // If $image is an instance of UploadedFile, use its original name as the public_id
                $options["public_id"] = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                if($strType == MediaTypes::LOGO->value) {
                    $obj->detachMedia($strType);
                }
                $obj->attachMedia($image , $strType , $options);
            } else {
                throw new \InvalidArgumentException('$image must be a string (URL) or an instance of UploadedFile');
            }

            return true;
        } catch (Exception $ex){
            return false;
        }
    }

    public static function updateImage(Object $obj , string $strFolderPath , string $strType, UploadedFile|string $image = null): bool {
        try {
            $options = [
                "cloud_name" => env("CLOUDINARY_CLOUD_NAME"),
                "public_id" => is_string($image) ? $image : pathinfo($image->getClientOriginalName() , PATHINFO_FILENAME),
                "folder" => sprintf($strFolderPath, $obj->id),
                "timeout" => 6000000,
            ];
            $obj->updateMedia($image , $strType , $options);
            return true;
        }catch (Exception $ex){
            return false;
        }
    }
}
