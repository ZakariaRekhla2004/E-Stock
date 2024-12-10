<?php
// File: AuditTable.php
namespace App\Model\Enums;

enum AuditTables: string
{
    case PRODUCT = 'PRODUCT';
    case CATEGORY = 'CATEGORY';
    case CLIENT = 'CLIENT';
    case USER = 'USER';
    case COMMANDE = 'COMMANDE';
}

?>