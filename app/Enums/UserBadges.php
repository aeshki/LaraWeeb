<?php

namespace App\Enums;

enum UserBadges: int
{
    case STAFF = 1 << 0;
    case DEVELOPER = 1 << 1;
    case NEW_MEMBER = 1 << 2;
}