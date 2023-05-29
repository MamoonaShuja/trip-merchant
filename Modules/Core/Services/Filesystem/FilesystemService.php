<?php

namespace Modules\Core\Services\Filesystem;

use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Modules\Core\Contracts\Services\Filesystem\FilesystemContract;

final class FilesystemService implements FilesystemContract
{
    /**
     * @param Filesystem $objFilesystem
     */
    public function __construct(
        private readonly Filesystem $objFilesystem
    ) {}

    public function save(string $path, string $content)
    {
        $this->objFilesystem->append($path, $content);
    }

    public function readFile(string $path): ?string
    {
        return $this->objFilesystem->get($path);
    }

    public function copy(UploadedFile|string $pathFrom, string $strPathTo, ?string $fileName = null)
    {
        if (is_string($pathFrom)) {
            $this->objFilesystem->copy($pathFrom, $strPathTo);
        } else {
            $this->objFilesystem->put($strPathTo . '/' . $fileName, $pathFrom->getContent());
        }
    }

    public function files(string $strDirectory): array
    {
        return $this->objFilesystem->files($strDirectory);
    }

    public function url(string $path): string
    {
        return $this->objFilesystem->url($path);
    }

    public static function factory(): self
    {
        return resolve(FilesystemContract::class);
    }
}
