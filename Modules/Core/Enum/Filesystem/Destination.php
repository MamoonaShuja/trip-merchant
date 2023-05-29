<?php

namespace Modules\Core\Enum\Filesystem;

enum Destination: string {
    case IMAGE = "destinations/%s/image.png";
    case DEFAULT_AVATAR = "destinations/default.png";
    case SLIDER = "/destinations/%s/slider/";
}
