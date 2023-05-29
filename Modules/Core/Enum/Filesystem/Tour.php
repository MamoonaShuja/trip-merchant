<?php

namespace Modules\Core\Enum\Filesystem;

enum Tour: string {
    case FEATURED = "/tour/%s/featured/";
    case CABIN_DECKS = "/tour/cabin-decks/%s/";
    case ESSENTIAL_INFO = "/tour/essential-info/%s/";
    case GALLERY = "/tour/%s/gallery/";
    case SLIDER = "/tour/%s/slider/";
    case API = "/tour/%s/%s/";
    case MAP = "/tour/map/%s/";
}
