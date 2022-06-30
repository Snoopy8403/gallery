<?php include("includes/init.php"); 

    if (!$session->isSignedIn()) {
        redirect("login.php");
    }

    if (empty($_GET['id'])) {
      redirect("photos.php");
    }

    $photo = Photo::findById($_GET['id']);

    if ($photo) {
      $photo->deletePhoto();
      redirect('photos.php');
    } else {
      redirect("photos.php");
    }


?>