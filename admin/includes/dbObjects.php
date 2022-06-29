<?php 

class DBObjects{
    protected static $db_table = "users";

    public static function findAll(){
        return static::findByQuery("SELECT * FROM " . static::$db_table . " ");
    }
    
    public static function findById($id){
        global $database;

        $result_array = static::findByQuery("SELECT * FROM " . static::$db_table . " WHERE id=$id LIMIT 1");

        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function findByQuery($sql){
        global $database;
        $result_set = $database->query($sql);
        $objectArray = array();
        while ($row = mysqli_fetch_array($result_set)) {
            $objectArray[] = static::instantation($row);
        }
        return $objectArray;
    }

    public static function instantation($data){

        $callingClass = get_called_class();

        $theObject = new $callingClass;

        foreach ($data as $attribute => $value) {
            if ($theObject->has_the_attribute($attribute)) {
                $theObject->$attribute = $value;
            }
        }

        return $theObject;
    }

    private function has_the_attribute($attribute){
        
        $objectProperties = get_object_vars($this);
        
        return array_key_exists($attribute, $objectProperties);
    }
    
    protected function properties(){
        $properties = array();
        foreach (static::$db_table_fields as $db_field) {
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

        $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")"; 
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

        $sql = "UPDATE " . static::$db_table ." SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id = " . $database->escapeString($this->id);

        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete(){
        global $database;

        $sql = "DELETE FROM " . static::$db_table . " WHERE id=" . $database->escapeString($this->id) . " LIMIT 1";
        
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }


}

?>