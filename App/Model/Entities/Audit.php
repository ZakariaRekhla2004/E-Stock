<?php
namespace App\Model\Entities;

class Audit {
    private $id;
    private $table_name;
    private $action_type;
    private $action_description;
    private $action_date;
    private $user_id;

    // Constructor
    public function __construct($id = null, $table_name = null, $action_type = null, $action_description = null, $action_date = null, $user_id = null) {
        $this->id = $id;
        $this->table_name = $table_name;
        $this->action_type = $action_type;
        $this->action_description = $action_description;
        $this->action_date = $action_date;
        $this->user_id = $user_id;
    }

    // Getter for id
    public function getId() {
        return $this->id;
    }

    // Setter for id
    public function setId($id) {
        $this->id = $id;
    }

    // Getter for table_name
    public function getTableName() {
        return $this->table_name;
    }

    // Setter for table_name
    public function setTableName($table_name) {
        $this->table_name = $table_name;
    }

    // Getter for action_type
    public function getActionType() {
        return $this->action_type;
    }

    // Setter for action_type
    public function setActionType($action_type) {
        $this->action_type = $action_type;
    }

    // Getter for action_description
    public function getActionDescription() {
        return $this->action_description;
    }

    // Setter for action_description
    public function setActionDescription($action_description) {
        $this->action_description = $action_description;
    }

    // Getter for action_date
    public function getActionDate() {
        return $this->action_date;
    }

    // Setter for action_date
    public function setActionDate($action_date) {
        $this->action_date = $action_date;
    }

    // Getter for user_id
    public function getUserId() {
        return $this->user_id;
    }

    // Setter for user_id
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }
}
?>
