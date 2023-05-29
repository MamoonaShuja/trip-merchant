<?php

namespace Modules\Core\Enum\Permissions;

enum Destination: string {
    case GET_DESTINATIONS = "get destinations";
    case SHOW_DESTINATION = "show destination";
    case STORE_DESTINATION = "store destination";
    case DELETE_DESTINATION = "delete destination";
    case UPDATE_DESTINATION = "update destination";
}
