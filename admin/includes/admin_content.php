
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
            // $users = User::findAll();
            // foreach ($users as $user) {
            //     echo $user->username . "<br>";
            // }

            //Felhasznalo ID szerint
            // $userById = User::findById(2);
            // echo "User by ID: " .  $userById->id . " Username: " . $userById->username;
            // echo "User by ID: " .  $userById->id . " Name " . $userById->first_name . " " . $userById->last_name;
            
            // $userById->last_name = "Elemer";

            // $userById->update();
            // echo "User by ID: " .  $userById->id . " Name " . $userById->first_name . " " . $userById->last_name;

            // $user = User::findUserById(2);
            // $user->username = "Lucky";

            // $user->delete();

            // $user = new User();
            // $user->username = "Dani";
            // $user->password = 123;
            // $user->first_name = "Da";
            // $user->last_name = "Ni";
            // $user->create();

            // $user = User::findById(5);
            // $user->username = "Atirat";
            // $user->password = "Password";
            // $user->first_name = "At";
            // $user->last_name = "Irat";
            // $user->update();



            // $photo = new Photo();
            // $photo->title = "Photo to Dog";
            // $photo->description = "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...";
            // $photo->size = "1234";
            // $photo->filename = "dog";
            // $photo->type = "jpg";
            // $photo->create();

            $photos = Photo::findAll();
            foreach ($photos as $photo) {
                echo "----------------------- <br>";
                echo "Kép címe: " . $photo->title . " <br><br>";
                echo "Leírás: " . $photo->description . " <br>";
                echo "Méret: " . $photo->size . " <br>";
                echo "Filenév: " . $photo->filename . " <br>";
                echo "Típus: " . $photo->type . " <br>";
                echo "-----------------------";
            }

            echo "Includes path: " . INCLUDES_PATH;

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
