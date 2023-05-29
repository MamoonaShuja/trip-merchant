<?php

namespace Modules\Core\Contracts\Services\Filesystem;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FilesystemContract
{
    public function readFile(string $path): ?string;
    public function save(string $path, string $content);

    public function copy(UploadedFile|string $pathFrom, string $strPathTo, ?string $fileName = null);

    public function files(string $strDirectory): array;

    public function url(string $path): string;

    public static function factory(): self;
}
