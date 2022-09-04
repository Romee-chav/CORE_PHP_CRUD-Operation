<?php

session_start();
require_once 'connection/config.php';

// Check if the user is loged in, if not the redirect to login page
if (!isset($_SESSION['user_data'])) {
    header('Location:index.php');
}

$sql = "SELECT * FROM users";
$execute = $conn->query($sql);

while ($data = $execute->fetch_object()) {
    $users[] = $data;
}

$states = [
    'gj' => "Gujarat",
    'dl' => "Delhi",
    'rj' => "Rajasthan",
    'mh' => "Maharashtra",
    "sk" => "Sikkim",
    'pb' => "Panjab"
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/bootstrap.css">
    <title>Show Data</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a href="#" class="navbar-brand">Core PHP CRUD</a>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                    <?php 
                    if (isset($_SESSION['user_data'])) {
                        echo "<a href='logout.php' class='btn btn-dark'>Logout</a>";
                    }else{
                        echo "<a href='index.php' class='btn btn-dark'>Login</a>";
                        header('Location:index.php');
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section>
            <!-- <a href="#" class="btn btn-primary" style="margin-top: 8px;
                    margin-left: 10rem;">Add Data</a> -->
            <div class="album py-5 bg-light" style="height:100vh;">
                <div class="row h-100 justify-content-center">
                    <table class="table table-hover" style="max-width: 65rem;">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">First name</th>
                                <th scope="col">Last name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Address</th>
                                <th scope="col">State</th>
                                <th scope="col">Hobbies</th>
                                <th scope="col">Profile</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if($execute->num_rows >0 )
                                {
                                ?>
                                <?php
                                    $i = 1;
                                    foreach ($users as $user) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo $user->first_name; ?></td>
                                    <td><?php echo $user->last_name; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo $user->mobile; ?></td>
                                    <td><?php echo $user->gender; ?></td>
                                    <td><?php echo $user->address; ?></td>
                                    <td><?php echo isset($states[$user->state]) ? $states[$user->state] : null; ?></td>
                                    <td><?php echo $user->hobbies; ?></td>
                                    <td>
                                        <img src="<?php echo 'uploads/' . $user->profile_img_name;?>" alt="alt" height="80px"
                                            width="80px" />
                                    </td>
                                    <td>
                                        <a href="update.php?user=<?php echo $user->id; ?>" class="btn btn-warning">Edit</a>
                                        <a href="delete.php?user=<?php echo $user->id; ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                <?php
                                    $i++;
                                    }
                                ?>
                                <?php
                                    }else
                                        {
                                        ?>
                                            <tr><td colspan=8 style='text-align:center'>No Data Found!</td></tr>
                                        <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
    <script src="asset/js/bootstrap.bundle.js"></script>
</body>

</html>