<?php

namespace mmerlijn\msgRepo\Enums;

enum OrderStatusEnum: string
{
    case FINAL = "F";
    case CORRECTION = "C";
    case EMPTY = "";
}