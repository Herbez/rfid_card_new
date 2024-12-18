<?php

$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "nodemcu_rfid_iot_projects";

// Create connection
try {
    $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
