<?php

session_start();
require_once 'connection/config.php';

// isset() checks whether data exists in the input fields.
// The register button is clicked and value will set (if condition is use).
if (isset($_POST['register'])) {
    // image Upload folder.
    $path = 'uploads/';
    
    // When Upload Image The Name and Extention store to database.
    $extension = pathinfo($_FILES['profile_img_name']['name'],PATHINFO_EXTENSION);

    // image name with date.
    $file_name = $_POST['first_name'].'_'.date('YmdHis').'.'.$extension;

    // using php ternary operator file is exists or not.
    $profile = (file_exists($_FILES['profile_img_name']['tmp_name'])) ? $file_name : null;

    // Defining array $insert_data and array key and database field name and value will be fetch.
    $insert_data = [
        // Array keys and database field name to store data into database.
        'first_name' => mysqli_real_escape_string($conn,$_POST['first_name']),
        'last_name' => mysqli_real_escape_string($conn,$_POST['last_name']),
        'email' => mysqli_real_escape_string($conn,$_POST['email']),
        'password' => mysqli_real_escape_string($conn,$_POST['password']),
        'mobile' => mysqli_real_escape_string($conn,$_POST['mobile']),
        'gender' => mysqli_real_escape_string($conn,$_POST['gender']),
        'address' => mysqli_real_escape_string($conn,$_POST['address']),
        'state' => mysqli_real_escape_string($conn,$_POST['state']),
        'profile_img_name' => $profile,
        // Array To String Convert using implode function comma(',') separated values store in database.
        'hobbies' => mysqli_real_escape_string($conn,implode(',',$_POST['hobbies']))
    ];
    // echo "<pre>";
    // print_r($insert_data);
    // exit;
    // Array keys using implode function comma(',') separated values.
    $columns = implode(',',array_keys($insert_data));
    // Array values using implode function comma("','") separated values.
    $values = implode("','",array_values($insert_data));
    // Prepare our SQL statement to prevent SQL injection.
    $sql = "INSERT INTO users ($columns) VALUES ('$values')";
    $insert = $conn->query($sql);
    if ($insert) {
        // is_null function is check data is fill or Not.
        if (!is_null($profile)) {
            // Now we will upload file with name and extension.
            move_uploaded_file($_FILES['profile_img_name']['tmp_name'], $path.$file_name);
        }
        header("Refresh:2; url=index.php");
    } else{
        header("Refresh:3; url=create.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/bootstrap.css">
    <title>Register</title>
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
                    <a href="index.php" class="btn btn-dark">Login</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section>
            <div class="album py-5 bg-light">
                <div class="row h-100 justify-content-center align-items-center">
                    <div class="card border-success" style="max-width: 65rem;padding: 2%;">
                        <h2> Registration </h2>
                        <hr>
                        <div class="card-body">
                            <?php
                            if(isset($insert)){
                                echo "<div class='alert alert-success' role='alert'>
                                        Data Inserted Succesfully!
                                    </div>";
                            } else {
                                echo "<div class='alert alert-danger' role='alert'>
                                        Something Went Wrong!
                                    </div>";
                            }
                            ?>
                            <form method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="fname" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            placeholder="Enter Your First Name" required="">
                                    </div>
                                    <div class="col">
                                        <label for="lname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            placeholder="Enter Your Last Name" required="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="name@example.com" required="">
                                    </div>
                                    <div class="col">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Enter the Password" required="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="mobile" class="form-label">Contact Number</label>
                                        <input type="tel" class="form-control" id="mobile" name="mobile"
                                            placeholder="Enter Your Mobile Number" required="">
                                    </div>
                                    <div class="col">
                                        <label for="gender" class="form-label">Gender</label><br>
                                        <input type="radio" id="gender" name="gender" value="Male">Male
                                        <input type="radio" id="gender" name="gender" value="Female">Female
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" rows="3" name="address"
                                            placeholder="Enter Your Address" required=""></textarea>
                                    </div>
                                    <div class="col">
                                        <label for="inputState" class="form-label">State</label>
                                        <select class="form-select" id="inputState" name="state"
                                            aria-label="Default select example" required="">
                                            <option selected disabled>Select</option>
                                            <option value="gj">Gujarat</option>
                                            <option value="dl">Delhi</option>
                                            <option value="rj">Rajasthan</option>
                                            <option value="mh">Maharashtra</option>
                                            <option value="sk">Sikkim</option>
                                            <option value="pb">Punjab</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="profile" class="form-label">Profile</label><br>
                                        <input type="file" class="form-control-file" name="profile_img_name"
                                            id="profile_img_name">
                                    </div>
                                    <div class="col">
                                        <label for="hobbies" class="form-label">Hobbies</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                name="hobbies[]" value="Travelling">
                                            <label class="form-check-label" for="inlineCheckbox1">Travelling</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                name="hobbies[]" value="Music">
                                            <label class="form-check-label" for="inlineCheckbox2">Music</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                name="hobbies[]" value="Coding">
                                            <label class="form-check-label" for="inlineCheckbox3">Coding</label>
                                        </div>
                                    </div>

                                </div><br>
                                <div class="mb-3">
                                    <input type="submit" name="register" id="register" value="Registration"
                                        class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="asset/js/bootstrap.bundle.js"></script>
</body>

</html>