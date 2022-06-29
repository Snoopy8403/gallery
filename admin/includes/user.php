<?php

class User extends DBObjects {

    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name','last_name');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name; 

    public static function verifyUser($username, $password){
        global $database;
        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";

        $result_array = self::findByQuery($sql);

        return !empty($result_array) ? array_shift($result_array) : false;
    }





   
} //End of the class

?>