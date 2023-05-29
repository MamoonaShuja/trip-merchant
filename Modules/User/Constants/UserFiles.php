<?php

namespace Modules\User\Constants;

final class UserFiles
{
    const DEFAULT_AVATARS_DIR = "common/default/avatars";

    const USER_AVATAR_FILE_PATH = "user/%s";
    const USER_AVATAR_FILE_NAME = "avatar.png";
    const USER_AVATAR_FULL_NAME = self::USER_AVATAR_FILE_PATH . "/" . self::USER_AVATAR_FILE_NAME;
}
