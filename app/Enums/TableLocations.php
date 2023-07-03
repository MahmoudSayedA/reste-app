<?php

namespace App\Enums;

enum TableLocations: string
{
    case Front = 'front';
    case Back = 'back';
    case Inside = 'inside';
    case Outside = 'outside';
}
