<?php

session_start();
require_once 'connection/config.php';

if (isset($_GET['user'])) {
    $id = mysqli_real_escape_string($conn,$_GET['user']);
    $select_user = "SELECT * FROM users WHERE id = $id";
    $select_execute = $conn->query($select_user);
    $user_data = $select_execute->fetch_object();

}else{
    header('Location:read.php');
}

// The Update button is clicked and value will set (if condition is use).
if (isset($_POST['update'])) {
    // image Upload folder.
    $path = 'uploads/';
    
    // When Upload Image The Name and Extension store to database.
    $extension = pathinfo($_FILES['profile_img_name']['name'],PATHINFO_EXTENSION);

    // image name with date.
    $file_name = $_POST['first_name'].'_'.date('YmdHis').'.'.$extension;

    // using php ternary operator file is exists or not.
    $profile = (file_exists($_FILES['profile_img_name']['tmp_name'])) ? $file_name : $user_data->profile_img_name;

    // Defining array $insert_data and array key and database field name and value will be fetch.
    $update_data = [
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
    
    $sql = "UPDATE users SET ";
    
    foreach($update_data as $key => $value){
        $sql .= "$key = '$value',";
    }
    $sql = rtrim($sql,',');
    $sql .= "WHERE id=".$id;
    $execute = $conn->query($sql);
    
    if ($execute) {
        // is_null function is check data is fill or Not.
        if (!is_null($profile)) {
            // Now we will upload file with name and extension.
            move_uploaded_file($_FILES['profile_img_name']['tmp_name'], $path.$file_name);
        }
        header("Refresh:2; url=read.php");
    } else{
        header("Refresh:3; url=read.php");
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
    <title>Update</title>
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
                        echo '<a href="read.php" class="btn btn-dark">Home</a>';
                        echo '<a href="logout.php" class="btn btn-dark">Logout</a>';
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section>
            <div class="album py-5 bg-light">
                <div class="row justify-content-center align-items-center">
                    <div class="card border-success" style="max-width: 65rem;padding: 2%;">
                        <h2> Update User </h2>
                        <hr>
                        <div class="card-body">
                            <?php
                            if(isset($execute)){
                                echo "<div class='alert alert-success' role='alert'>
                                        Data Updated Successfully!
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
                                            placeholder="Enter Your First Name" value="<?php echo $user_data->first_name; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="lname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            placeholder="Enter Your Last Name" required="" value="<?php echo $user_data->last_name; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="name@example.com" required="" value="<?php echo $user_data->email; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Enter the Password" required="" value="<?php echo $user_data->password; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="mobile" class="form-label">Contact Number</label>
                                        <input type="tel" class="form-control" id="mobile" name="mobile"
                                            placeholder="Enter Your Mobile Number" required="" value="<?php echo $user_data->mobile; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="gender" class="form-label">Gender</label><br>
                                        <input type="radio" id="gender" name="gender" value="Male" <?php if ($user_data->gender == 'Male') {
                                            echo 'checked';
                                        } ?>>Male
                                        <input type="radio" id="gender" name="gender" value="Female" <?php if ($user_data->gender == 'Female') {
                                            echo 'checked';
                                        } ?>>Female
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" rows="3" name="address"
                                            placeholder="Enter Your Address" required=""><?php echo $user_data->address; ?></textarea>
                                    </div>
                                    <div class="col">
                                        <label for="inputState" class="form-label">State</label>
                                        <select class="form-select" id="inputState" name="state"
                                            aria-label="Default select example" required="">
                                            <option disabled>Select</option>
                                            <option value="gj" 
                                            <?php if ($user_data->state == 'gj') {
                                                echo 'selected';
                                            } 
                                            ?>
                                            >Gujarat</option>
                                            <option value="dl" 
                                            <?php if ($user_data->state == 'dl') {
                                                echo 'selected';
                                            } 
                                            ?>
                                            >Delhi</option>
                                            <option value="rj" 
                                            <?php if ($user_data->state == 'rj') {
                                                echo 'selected';
                                            } 
                                            ?>
                                            >Rajasthan</option>
                                            <option value="mh" 
                                            <?php if ($user_data->state == 'mh') {
                                                echo 'selected';
                                            } 
                                            ?>
                                            >Maharashtra</option>
                                            <option value="sk" 
                                            <?php if ($user_data->state == 'sk') {
                                                echo 'selected';
                                            } 
                                            ?>
                                            >Sikkim</option>
                                            <option value="pb" 
                                            <?php if ($user_data->state == 'pb') {
                                                echo 'selected';
                                            } 
                                            ?>
                                            >Punjab</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="profile" class="form-label">Profile</label><br>
                                        <img src="uploads/<?php echo $user_data->profile_img_name; ?>" height="80px" width="80px">
                                        <input type="file" value="uploads/<?php echo $user_data->profile_img_name; ?>" src="uploads/<?php echo $user_data->profile_img_name; ?>" class="form-control-file" name="profile_img_name"
                                            id="profile_img_name">
                                    </div>
                                    <div class="col">
                                        <label for="hobbies" class="form-label">Hobbies</label><br>
                                        <?php $hobbies_arr = explode(',',$user_data->hobbies); ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                name="hobbies[]" value="Traveling"
                                                <?php
                                                if (in_array('Traveling',$hobbies_arr)) {
                                                    echo 'checked';
                                                }
                                                ?>
                                                >
                                            <label class="form-check-label" for="inlineCheckbox1">Traveling</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                name="hobbies[]" value="Music"
                                                <?php
                                                if (in_array('Music',$hobbies_arr)) {
                                                    echo 'checked';
                                                }
                                                ?>
                                                >
                                            <label class="form-check-label" for="inlineCheckbox2">Music</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                name="hobbies[]" value="Coding"
                                                <?php
                                                if (in_array('Coding',$hobbies_arr)) {
                                                    echo 'checked';
                                                }
                                                ?>
                                                >
                                            <label class="form-check-label" for="inlineCheckbox3">Coding</label>
                                        </div>
                                    </div>

                                </div><br>
                                <div class="mb-3">
                                    <input type="submit" name="update" id="update" value="Update"
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