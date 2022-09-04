<?php

    session_start();
    // Unset all session variables
    unset($_SESSION['user_date']);
    // get session parameters
    // $params = session_get_cookie_params();
    // // Delete cookie
    // setcookie(session_name(),'',time() - 42000,
    //         $params['path'],
    //         $params['domain'],
    //         $params['secure'],
    //         $params['httponly']);
    // Destroy session
    session_destroy();
    // Redirect to login page
    header('Location:index.php');

?>