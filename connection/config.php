<?php
// MySQL Database credentials
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'core_php_crud';

// Attempt to Connect to MYSQL database
mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $conn = new mysqli($servername,$username,$password,$dbname);
        date_default_timezone_set('Asia/Kolkata');
    } catch (\Throwable $th) {
        echo "connection Failed" . $th->getMessage();
        exit();
    }
    
?>