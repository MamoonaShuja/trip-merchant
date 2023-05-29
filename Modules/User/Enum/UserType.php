<?php

namespace Modules\User\Enum;

enum UserType: string {
    case MEMBER = "member";
    case ADMIN = "admin";
    case ORGANIZER = "organizer";
    case SUPPLIER = "supplier";
    case EMPLOYEE = "employee";
}
