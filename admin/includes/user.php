<?php

class User {

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

        $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";

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

    public function create(){
        global $database;
        
        $sql = "INSERT INTO users (username, password, first_name, last_name)"; 
        $sql .= "VALUES ('";
        $sql .= $database->escapeString($this->username) . "','";
        $sql .= $database->escapeString($this->password) . "','";
        $sql .= $database->escapeString($this->first_name) . "','";
        $sql .= $database->escapeString($this->last_name) ." ')";
  
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
        
        $sql = "UPDATE users SET ";
        $sql .= "username = '" . $database->escapeString($this->username) . "',";
        $sql .= "password = '" . $database->escapeString($this->username) . "',"; 
        $sql .= "first_name = '" . $database->escapeString($this->username) . "',"; 
        $sql .= "last_name ='" . $database->escapeString($this->username) . "'"; 
        $sql .= " WHERE id = " . $database->escapeString($this->id);
        
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete(){
        global $database;

        $sql = "DELETE FROM users WHERE id=" . $database->escapeString($this->id) . " LIMIT 1";
        
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

} //End of the class

?>