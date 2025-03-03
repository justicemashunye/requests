<?php
namespace App\Enums;

enum RequisitionUrgency: string
    {
        case URGENT = 'urgent';
        case VERYURGENT = 'very-urgent';
        case NORMAL = 'normal';
       
    }