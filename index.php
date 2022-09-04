<?php

session_start();
require_once 'connection/config.php';

    if (isset($_POST['login'])) {
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        // Prepare our SQL statement to prevent SQL injection.
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $execute = $conn->query($sql);
        if ($execute->num_rows > 0) {
            // Create session to know the user is logged in
            // Store session data and session name is user_data.
            $_SESSION['user_data'] = $execute->fetch_object();
            header("Refresh:1, url=read.php");
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
    <title>Home</title>
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
                    <a href="create.php" class="btn btn-dark">Registration</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section>
            <div class="album py-5 bg-light" style="height:100vh;">
                <div class="row h-100 justify-content-center align-items-center">
                    <div class="card border-success" style="max-width: 30rem;padding: 2%;">
                        <h2> Login </h2>
                        <hr>
                        <div class="card-body">
                            <?php
                            if (isset($_SESSION['user_data'])) {
                                echo "<div class='alert alert-success' role='alert'>
                                        Welcome ".$_SESSION['user_data']->first_name."
                                    </div>";
                            } elseif(isset($execute) && $execute->num_rows < 1) {
                                echo "<div class='alert alert-danger' role='alert'>
                                        Email or password is invalid!
                                    </div>";
                            }
                            ?>
                            <form method="post">
                                <div class="mb-3">
                                    <label for="login_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="login_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="password">
                                </div>
                                <div class="mb-3">
                                    <input type="submit" name="login" id="login" value="Login" class="btn btn-primary">
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