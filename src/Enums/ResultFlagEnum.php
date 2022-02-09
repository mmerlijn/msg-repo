<?php

namespace mmerlijn\msgRepo\Enums;

enum ResultFlagEnum: string
{
    case HIGH = "H"; //new
    case LOW = "L"; //Cancel
    case EMPTY = "";
}