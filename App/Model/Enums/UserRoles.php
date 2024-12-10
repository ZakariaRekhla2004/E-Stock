<?php
namespace App\Model\Enums;

enum UserRoles: string
{
    case COMERCIAL = 'COMERCIAL';
    case ACHAT = 'ACHAT';
    case RH = 'RH';
    case DIRECTION = 'DIRECTION';
    case ADMIN = 'ADMIN';
}
?>