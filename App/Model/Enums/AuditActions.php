<?php 
namespace App\Model\Enums;

enum AuditActions: string {
    case CREATE = 'Créer';
    case UPDATE = 'Mettre à jour';
    case DELETE = 'Supprimer';
    case READ = 'Lire';
    case RESTORE = 'Restaurer';
}
?>
