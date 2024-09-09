<?php

$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "student_card";
// Create connection
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
// Check connection
if (!$conn) {
    echo "Connected unsuccessfully";
    die("Connection failed: " . mysqli_connect_error());
}
?>