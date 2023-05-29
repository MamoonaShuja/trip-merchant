<?php

namespace Modules\Core\Helpers\Filesystem;

use Illuminate\Contracts\Filesystem\Filesystem;

abstract class BaseFilesystem {
    protected static ?Filesystem $filesystem;

    protected const DS = DIRECTORY_SEPARATOR;
}