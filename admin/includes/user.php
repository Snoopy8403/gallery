<?php

class User extends DBObjects {

    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name','last_name','user_image');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image; 

    public $upload_directory = "images";
    public $image_placeholder = "https://via.placeholder.com/150";

    public function setFile($file){

        if (empty($file) || !$file || !is_array($file)) {
            $this->custom_errors_array[] = "There was no file uploded here";
            return false;
        }
        elseif ($file['error'] !=0) {
            $this->custom_errors_array[] = $this->upload_errors_array[$file['error']];
            return false;
        }
        else {
            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    public function saveUserAndImage(){
        if ($this->id) {
            $this->update();
        }
        else {
            if (!empty($this->custom_errors_array)) {
                return false;
            }
            if (empty($this->user_image) || empty($this->tmp_path)) {
                $this->custom_errors_array[] = "The file was not available";
                return false;
            }
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
            
            if (file_exists($target_path)) {
                $this->custom_errors_array[] = "The file {$this->user_image} alredy exists";
                return false;
            }

            if (move_uploaded_file($this->tmp_path, $target_path)) {
                if ($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }
            }
            else {
                $this->custom_errors_array[] = "The file directory was not permission";
                return false;
            }
        }
    }

    public function imagePathAndPlaceholder(){
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
    }

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