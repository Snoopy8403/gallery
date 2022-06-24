
<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin
            <small>Subheading</small>
        </h1>

    

        <div>
        <p>
        Database status: <?php if($database->connection){echo "true"; } ?>

        </p>
        <?php
        
            //Minden felhasznasznalo
            $users = User::findAllUsers();
            foreach ($users as $user) {
                echo $user->username . "<br>";
            }

            //Felhasznalo ID szerint
            $userById = User::findUserById(2);
            echo "User by ID: " .  $userById->id . " Username: " . $userById->username;
            echo "User by ID: " .  $userById->id . " Name " . $userById->first_name . " " . $userById->last_name;
            

?>


            
        </div>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Blank Page
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->
