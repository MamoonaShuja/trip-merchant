<?php

namespace Modules\Tour\Enum;

enum RatingTypes: string {
    case ACCOMMODATION = "Accommodation";
    case MEALS = "Meals";
    case OVERALL = "Overall";
    case TRANSPORTATION = "Transportation";
}
