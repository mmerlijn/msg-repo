<?php

namespace mmerlijn\msgRepo\Enums;

enum PatientSexEnum: string
{
    case FEMALE = "F";
    case MALE = "M";
    case OTHER = "X";
    case EMPTY = "";
}