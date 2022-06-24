<?php 

require_once("config.php");

class Database {

    public $connection;

    function __construct()
    {
        $this->open_db_connection();
    }

    public function open_db_connection(){
        $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if($this->connection->connect_errno){
              die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    public function query($sql){
        $result = $this->connection->query($sql);
        $this->confirmQuery($result);
        return $result;
    }

    private function confirmQuery($result){
        if(!$result){
            die("Failed" . $this->connection->error);
        }
    }

    public function escapeString($string){
        $escaped_string = $this->connection->real_escape_string($string);
        return $escaped_string;
    }
}

$database = new Database();
?>