<?php include("includes/init.php"); 

    if (!$session->isSignedIn()) {
        redirect("login.php");
    }

    if (empty($_GET['id'])) {
      redirect("users.php");
    }

    $user = User::findById($_GET['id']);

    if ($user) {
      $user->delete();
      redirect('users.php');
    } else {
      redirect("users.php");
    }


?>