<?php

namespace App\Enums;

enum TableStatus: string
{
    case Available = 'available';
    case Pandding = 'pandding';
    case Unavailable = 'unavailable';
}
