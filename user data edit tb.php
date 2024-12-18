<?php
require 'database.php';

if (!empty($_POST)) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    // $year_of_study = $_POST['year_of_study'];
    $class = $_POST['class'];
    // $department = $_POST['department'];

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Define the upload directory
        $uploadDir = 'uploads/';
        // Generate a unique name for the uploaded file
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
        
        // Move the uploaded file to the designated folder
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            // Update photo path in the database
            $photo = $_FILES['photo']['name'];
        }
    } else {
        // If no new photo uploaded, keep the old one
        $photo = $_POST['photo']; // Add hidden input for old photo value
    }

    // Update the database record
    $pdo = Database::connect();
    // $sql = "UPDATE table_the_iot_projects SET name = ?, year_of_study = ?, class = ?, department = ?, photo = ? WHERE id = ?";
    $sql = "UPDATE table_the_iot_projects SET name = ?, class = ?, photo = ? WHERE id = ?";
    $q = $pdo->prepare($sql);
    // $q->execute(array($name, $year_of_study, $class, $department, $photo, $id));
    $q->execute(array($name, $class, $photo, $id));

    Database::disconnect();

    header("Location: user data.php");
}
?>
