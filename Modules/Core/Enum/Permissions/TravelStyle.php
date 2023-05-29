<?php

namespace Modules\Core\Enum\Permissions;

enum TravelStyle: string {
    case GET_TRAVEL_STYLES = "get travel-styles";
    case SHOW_TRAVEL_STYLE = "show travel-style";
    case STORE_TRAVEL_STYLE = "store travel-style";
    case DELETE_TRAVEL_STYLE = "delete travel-style";
    case UPDATE_TRAVEL_STYLE = "update travel-style";
}
