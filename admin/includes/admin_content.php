
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
            
            // $userById->last_name = "Elemer";

            // $userById->update();
            // echo "User by ID: " .  $userById->id . " Name " . $userById->first_name . " " . $userById->last_name;

            // $user = User::findUserById(2);
            // $user->username = "Lucky";

            // $user->delete();

            $user = new User();
             $user->username = "Dani";
             $user->password = 123;
             $user->first_name = "Da";
             $user->last_name = "Ni";
            $user->create();

            $user = User::findUserById(5);
            $user->username = "Atirat";
            $user->password = "Password";
            $user->first_name = "At";
            $user->last_name = "Irat";
            $user->update();
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
