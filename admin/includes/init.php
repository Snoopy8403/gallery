<?php 

    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
    defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:' . DS . 'xampp'. DS . 'htdocs' . DS . 'gallery' );
    defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes');

    include_once("functions.php");
    include_once("config.php");
    include_once("database.php");
    include_once("dbObjects.php");
    include_once("user.php");
    include_once("photo.php");
    include_once("session.php");
?>