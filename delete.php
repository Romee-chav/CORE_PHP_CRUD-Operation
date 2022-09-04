<?php
require_once 'connection/config.php';

if (isset($_GET['user'])) {
    $user_id = mysqli_real_escape_string($conn,$_GET['user']);
    $delete_user = "DELETE FROM users WHERE id = $user_id";
    $delete_execute = $conn->query($delete_user);
    header('Location:read.php');
}

?>