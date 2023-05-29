<?php

namespace Modules\Core\Enum\Filesystem;

enum User: string {
    case AVATAR = "/users/%s/avatar.png";
    case DEFAULT_AVATAR = "/users/avatar.png";
    case LOGO = "/supplier/logo.png";
}
