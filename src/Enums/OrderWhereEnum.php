<?php

namespace mmerlijn\msgRepo\Enums;

enum OrderWhereEnum: string
{
    case HOME = "H"; //Home
    case OTHER = "O"; //Other
    case EMPTY = "";
}