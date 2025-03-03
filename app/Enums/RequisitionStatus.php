<?php
namespace App\Enums;

enum RequisitionStatus: string
    {

        case SUPERVISOR = 'supervisor';
        case APPROVED = 'approved';
        case REJECTED = 'rejected';
        case PROCUREMENT = 'procurement';
        case FINANCE = 'finance';
        case FULFILLED = 'fulfilled';
        case ADMINISTRATION = 'administration';
        case PERMSEC = 'permsec';
        case PENDING = 'pending';
        case CLOSED = 'closed';


        public static function getLabels(): array
        {
            return [
                self::PENDING->value => 'pending',
                self::APPROVED->value => 'approved',
                self::REJECTED->value => 'rejected',
                self::SUPERVISOR->value => 'supervisor',
                self::PROCUREMENT->value => 'procurement',
                self::FINANCE->value => 'finance',
                self::ADMINISTRATION->value => 'administration',
                self::PERMSEC->value => 'permsec',
                self::CLOSED->value => 'closed',
              
            ];
        }
    

    }

        