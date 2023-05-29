<?php

namespace Modules\Core\Traits;

use Cloudinary\Cloudinary;
use CloudinaryLabs\CloudinaryLaravel\CloudinaryEngine;
use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Exception;

/**
 * MediaAlly
 *
 * Provides functionality for attaching Cloudinary files to an eloquent model.
 * Whether the model should automatically reload its media relationship after modification.
 *
 */
trait CustomMediaAlly
{
    public function medially()
    {
        return $this->morphMany(Media::class, 'medially');
    }


    /**
     * Attach Media Files to a Model
     */
    public function attachMedia($file,$type ,  $options = [])
    {
        try {
            $response = resolve(CloudinaryEngine::class)->uploadFile(is_string($file) ? $file : $file->getRealPath(), $options);
            sleep(1);
        }catch (\Throwable $ex){

        }
        $media = new Media();
        $media->file_name = $response->getFileName();
        $media->file_url = $response->getSecurePath();
        $media->size = $response->getSize();
        $media->file_type = $response->getFileType();
        $media->type = $type;
        $this->medially()->save($media);
    }

    /**
     * Attach Rwmote Media Files to a Model
     */
    public function attachRemoteMedia($remoteFile, $options = [])
    {
        $response = resolve(CloudinaryEngine::class)->uploadFile($remoteFile, $options);
        $media = new Media();
        $media->file_name = $response->getFileName();
        $media->file_url = $response->getSecurePath();
        $media->size = $response->getSize();
        $media->file_type = $response->getFileType();
        $media->type = $response->getFileType();

        $this->medially()->save($media);
    }

    /**
     * Get all the Media files relating to a particular Model record
     */
    public function fetchAllMedia(string $type)
    {
        return $this->medially()->whereType($type)->get();
    }

    /**
     * Get the first Media file relating to a particular Model record
     */
    public function fetchFirstMedia()
    {
        return $this->medially()->first();
    }

    /**
     * Delete all/ file(s) associated with a particular Model record on basis of type
     */
    public function detachMedia(string $type , Media $media = null)
    {
        $items = $this->fetchAllMedia($type);
        foreach($items as $item) {
            if (!is_null($item->id)) {
                $item->delete();
                resolve(CloudinaryEngine::class)->destroy($item->getFileName());
            }
        }
    }

    public function detachMediaById(string $type , string $id = null)
    {

        $items = $this->fetchAllMedia($type);
        foreach($items as $item) {
            if (!is_null($id) && $item->id == $id) {
                try {
                    resolve(CloudinaryEngine::class)->destroy($item->getFileName());
                }catch (Exception $exception){
                    dd("exception");
                }
                return $item->delete();
            }
        }
        return true;
    }
    /**
     * Get the last Media file relating to a particular Model record
     */
    public function fetchLastMedia(string $type)
    {
        return $this->medially()->whereType($type)->get()->last();
    }

    /**
     * Update the Media files relating to a particular Model record
     */
    public function updateMedia($file, string $type , $options = [])
    {
        $this->detachMedia($type);
        $this->attachMedia($file, $options);
    }

    /**
     * Update the Media files relating to a particular Model record (Specificially existing remote files)
     */
    public function updateRemoteMedia($file, string $type , $options = [])
    {
        $this->detachMedia($type);
        $this->attachRemoteMedia($file, $options);
    }

}
