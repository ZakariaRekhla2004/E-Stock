<?php 
namespace App\Model\Enums;

enum AuditActions: string {
    case CREATE = 'CREATE';
    case UPDATE = 'UPDATE';
    case DELETE = 'DELETE';
    case READ = 'READ';
}
?>