<?php 

require_once("includes/header.php");

if ($session->isSignedIn()) {
    redirect("index.php");
}

if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user_found = User::verifyUser($username, $password);

    if ($user_found) {
        $session->login($user_found);
        redirect("index.php");
    }
    else {
        $message = "The username or password is incorrect!";
    }

}
else{
    $username = "";
    $password = "";
    $message = "";
}
?>


<div class="col-md-4 col-md-offset-3">
<h4 class="bg-danger"><?php echo $message; ?></h4>
<form id="login-id" action="" method="post">
	
    <div class="form-group">
        <label for="username"><p>Username</p></label>
        <input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >

    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">
        
    </div>

    <div class="form-group">
    <input type="submit" name="submit" value="Submit" class="btn btn-primary">

    </div>
</form>
</div>