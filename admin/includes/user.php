<?php

class User {

    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name','last_name');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name; 

    public static function findAllUsers(){
        return self::findThisQuery("SELECT * FROM users");
    }
    
    public static function findUserById($id){
        global $database;

        $result_array = self::findThisQuery("SELECT * FROM users WHERE id=$id LIMIT 1");

        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function findThisQuery($sql){
        global $database;
        $result_set = $database->query($sql);
        $objectArray = array();
        while ($row = mysqli_fetch_array($result_set)) {
            $objectArray[] = self::instantation($row);
        }


        return $objectArray;
    }

    private function has_the_attribute($attribute){
        
        $objectProperties = get_object_vars($this);
        
        return array_key_exists($attribute, $objectProperties);
    }

    public static function verifyUser($username, $password){
        global $database;
        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";

        $result_array = self::findThisQuery($sql);

        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function instantation($data){
        $theObject = new self;

        foreach ($data as $attribute => $value) {
            if ($theObject->has_the_attribute($attribute)) {
                $theObject->$attribute = $value;
            }
        }

        return $theObject;
    }

    protected function properties(){
        $properties = array();
        foreach (self::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    protected function cleanProperties(){
        global $database;

        $clean_properties = array();
        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escapeString($value);
        }

        return $clean_properties;

    }

    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create(){
        global $database;
        $properties = $this->cleanProperties();

        $sql = "INSERT INTO " . self::$db_table . "(" . implode(",", array_keys($properties)) . ")"; 
        $sql .= "VALUES ('". implode("','", array_values($properties)) ."')";
  
        if ($database->query($sql)) {
            $this->id = $database->insertId();
            return true;
        }
        else {
            return false;
        }
    }
    public function update(){
        global $database;
        $properties = $this->cleanProperties();
        $properties_pairs = array();

        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . self::$db_table ." SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id = " . $database->escapeString($this->id);

        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    // Original Update function (not Abstract!)   
    /*     public function update(){
        global $database;
        
        $sql = "UPDATE " . self::$db_table ." SET ";
        $sql .= "username = '" . $database->escapeString($this->username) . "',";
        $sql .= "password = '" . $database->escapeString($this->password) . "',"; 
        $sql .= "first_name = '" . $database->escapeString($this->first_name) . "',"; 
        $sql .= "last_name ='" . $database->escapeString($this->last_name) . "'"; 
        $sql .= " WHERE id = " . $database->escapeString($this->id);
        
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    } */

    public function delete(){
        global $database;

        $sql = "DELETE FROM " . self::$db_table . " WHERE id=" . $database->escapeString($this->id) . " LIMIT 1";
        
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

} //End of the class

?>