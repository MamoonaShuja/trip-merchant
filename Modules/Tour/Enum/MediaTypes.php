<?php

namespace Modules\Tour\Enum;

enum MediaTypes: string {
    case GALLERY = "gallery";
    case FEATURED = "image";
    case CABIN_DECKS = "cabin-decks";
    case SLIDER = "slider";
    case LOGO = "logo";
    case ESSENTIAL_INFO = "essential-info";
    case API = "api";
    case MAP = "map";
}
