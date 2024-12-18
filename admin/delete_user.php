<?php
session_start();

// Include the database connection
require 'dbconn.php';

// Ensure the user is logged in
if (!isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit();
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id'];

    try {
        // Prepare the SQL query to delete the user from the database
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            // If successful, redirect back to the users list with a success message
            header("Location: allusers.php");
            exit();
        } else {
            // If the deletion fails, redirect with an error message
            header("Location: allusers.php");
            exit();
        }

    } catch (Exception $e) {
        // In case of an exception, redirect with the error message
        header("Location: allusers.php?error=" . $e->getMessage());
        exit();
    }
} else {
    // If no 'id' is provided, redirect with an error message
    header("Location: allusers.php?error=Invalid request");
    exit();
}
?>
