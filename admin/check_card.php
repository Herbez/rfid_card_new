<?php
// Database connection
require('dbconn.php');

// Get card number from POST request
$card_num = $_POST['UIDresult'];

try {
    // Prepare the SQL statement to select the student based on the card number
    $sql = "SELECT t.name, t.id, t.year_of_study, t.class, t.photo 
            FROM table_the_iot_projects t
            LEFT JOIN report r ON t.id = r.sid
            WHERE t.id = :card_num";
    
    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->execute([':card_num' => $card_num]);

    // Check if the card number exists
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $student_id = $row['id'];

        // Insert the student ID into the report table
        $sql_insert = "INSERT INTO report (sid) VALUES (:sid)";
        $insert_stmt = $conn->prepare($sql_insert);
        $insert_stmt->execute([':sid' => $student_id]);
    }
} catch (PDOException $e) {
    // Handle errors gracefully
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
