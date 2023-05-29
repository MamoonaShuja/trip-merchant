<?php

namespace Modules\Core\Enum\Filesystem;

enum Setting: string {
    case LOGO = "/settings/%s/logo.png";
    case SLIDER = "/settings/slider/%s/";
}
