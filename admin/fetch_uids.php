<?php
// Database credentials
$servername = "localhost"; // Replace with your database server
$username = "root";       // Replace with your database username
$password = "";           // Replace with your database password
$dbname = "nodemcu_rfid_iot_projects"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select registered IDs
$sql = "SELECT id FROM table_the_iot_projects"; // Replace 'registered_cards' and 'uid' with your table and column names
$result = $conn->query($sql);

$registeredUIDs = array();

if ($result->num_rows > 0) {
    // Fetch all rows and add to the array
    while ($row = $result->fetch_assoc()) {
        $registeredUIDs[] = $row['id'];
    }
} else {
    echo "No registered IDs found.";
}

// Close connection
$conn->close();

// Return the array in JSON format
header('Content-Type: application/json');
echo json_encode($registeredUIDs);
?>
