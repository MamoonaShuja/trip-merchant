<?php

namespace Modules\Core\Enum\Permissions;

enum Subscriber: string {
    case GET_SUBSCRIBERS = "get subscribers";
    case SHOW_SUBSCRIBER = "show subscribers";
    case STORE_SUBSCRIBER = "store subscriber";
    case DELETE_SUBSCRIBER = "delete subscriber";
    case UPDATE_SUBSCRIBER = "update subscriber";
}
