<?php

namespace Modules\Core\Enum\Filesystem;

enum TravelStyle: string {
    case IMAGE = "TravelStyle/%s/image.png";
    case DEFAULT_AVATAR = "TravelStyle/default.png";
    case SLIDER = "/TravelStyle/%s/slider/";
}
