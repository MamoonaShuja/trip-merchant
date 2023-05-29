<?php

namespace Modules\Core\Enum\Permissions;

enum User: string {
    case GET_MEMBERS = "get members";
    case GET_ORGANIZERS = "get organizers";
    case GET_SUPPLIERS = "get suppliers";
    case GET_EMPLOYER = "get employer";
    case GET_ADMINS = "get admins";
    case CREATE_ADMIN = "create admin";
    case UPDATE_ORGANIZATION_STATUS = "update organization status";
    case UPDATE_SUPPLIER_STATUS = "update supplier status";
    case UPDATE_PERMISSIONS = "update permissions";
}
