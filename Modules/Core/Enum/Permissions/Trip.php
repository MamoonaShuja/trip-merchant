<?php

namespace Modules\Core\Enum\Permissions;

enum Trip: string {
    case GET_TRIPS = "get trips";
    case GET_DELETED_TRIPS = "get deleted trips";
    case SHOW_TRIP = "show trip";
    case STORE_TRIP = "store trip";
    case DELETE_TRIP = "delete trip";

    case GET_TRIP_QUOTES = "get quotes";
    case SHOW_TRIP_QUOTE = "show quote";
    case UPDATE_TRIP_QUOTE = "update quote";
    case DELETE_TRIP_QUOTE = "delete quote";
    case UPDATE_TRIP = "update trip";
    case UPDATE_TRIP_SLIDER = "update trip slider";
    case UPDATE_TRIP_GALLERY = "update trip gallery";
    case DELETE_TRIP_GALLERY = "delete trip gallery";
    case DELETE_TRIP_SLIDER = "delete trip slider";
}
