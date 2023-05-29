<?php

namespace Modules\Core\Enum\Permissions;

enum City: string {
    case GET_CITIES = "get cities";
    case SHOW_CITY = "show city";
    case STORE_CITY = "store city";
    case DELETE_CITY = "delete city";
    case UPDATE_CITY = "update city";
}
