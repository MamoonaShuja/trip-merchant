<?php

namespace Modules\Tour\Enum;

enum Meals: string {
    case BREAKFAST = "Breakfast";
    case DINNER = "Dinner";
    case LUNCH = "Lunch";
    case BREAKFAST_DINNER_LUNCH = "Breakfast Lunch Dinner";
    case BREAKFAST_LUNCH = "Breakfast Lunch";
    case BREAKFAST_DINNER = "Breakfast Dinner";
    case LUNCH_DINNER = "Lunch Dinner";
}
