<?php include("includes/init.php"); ?>
<?php 

    if (!$session->isSignedIn()) {
        redirect("login.php");
    }
?>
  
  <?php 
  
  if (empty($_GET['id'])) {
    redirect("photos.php");
  }

  $photo = Photo::findById($_GET['id']);

  if ($photo) {
    $photo->delete_photo();
  } else {
    redirect("photos.php");
  }


?>