<?php 

class Session {

    private $signed_in = false;
    public $user_id;
    public $message;
    
    function __construct(){
        session_start();
        $this->checkTheLogin();
        $this->checkMessage();
    }

    public function isSignedIn(){
        return $this->signed_in;
    }

    public function login($user){
        if ($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    private function checkTheLogin(){
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        }
        else {
            unset($this->user_id);
            $this->igned_in = false;

        }
    }

    public function message($msg=""){
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        }
        else{
            return $this->message;
        }
    }

    private function checkMessage(){
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            //Unsetelni kell ha az oldal frissitve van akkor ne jelenleg meg újra az uzenet.
            unset($_SESSION['message']);
        }
        else{
            $this->message = "";
        }
    }
}

$session = new Session();

?>