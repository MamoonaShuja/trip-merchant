<?php

namespace Modules\Core\Enum\Permissions;

enum Country: string {
    case GET_COUNTRIES = "get countries";
    case SHOW_COUNTRY = "show country";
    case STORE_COUNTRY = "store country";
    case DELETE_COUNTRY = "delete country";
    case UPDATE_COUNTRY = "update country";
}
