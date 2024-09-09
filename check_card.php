<?php
// Database connection
require('dbconn.php');

// Get card number from POST request
$card_num = $_POST['UIDresult'];

// Check if the card number exists in the students table and if it is linked in check_student
$sql = "SELECT t.name,t.id, t.year_of_study, t.class, t.department, t.photo 
        FROM  table_the_iot_projects t LEFT JOIN report r ON t.id = r.sid
        WHERE t.id = '$card_num'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // If card exists, insert into check_student table with status 1
    $row = $result->fetch_assoc();
    $student_id = $row['id'];
    
    $sql_insert = "INSERT INTO report (sid) VALUES ('$student_id')";
    $conn->query($sql_insert);
} 

$conn->close();
?>
