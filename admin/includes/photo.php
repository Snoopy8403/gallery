<?php 

class Photo extends DBObjects {
    protected static $db_table = "photos";
    protected static $db_table_fields = array('id','title', 'description', 'size','filename','type');
    public $id;
    public $title;
    public $description;
    public $size;
    public $filename;
    public $type;

    public $tmp_path;
    public $upload_directory = "images";
    public $custom_errors_array = array();
    public $upload_errors_array = array(
        UPLOAD_ERR_OK           => "There is no error",
        UPLOAD_ERR_NO_FILE      => "No file was uploaded",
        UPLOAD_ERR_INI_SIZE     => "The uploaded file extends the upload_max_filesize directive",
        UPLOAD_ERR_FORM_SIZE    => "The uploaded file extends the MAX_FILE_SIZE directive",
        UPLOAD_ERR_PARTIAL      => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload. "
    );

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
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    public function save(){
        if ($this->id) {
            $this->update();
        }
        else {
            if (!empty($this->custom_errors_array)) {
                return false;
            }
            if (empty($this->filename) || empty($this->tmp_path)) {
                $this->custom_errors_array[] = "The file was not available";
                return false;
            }
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;    
        }
    }


}

?>