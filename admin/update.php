<?php 
require('dbconn.php');

$id = $_GET['id'] ?? '';
// Retrieve form data
$name = $_POST['name'] ?? '';
$year_of_study = $_POST['year_of_study'] ?? '';
$class = $_POST['class'] ?? '';
$photo = $_FILES['photo']['name'] ?? '';
$photo_tmp = $_FILES['photo']['tmp_name'] ?? '';

// Validate fields
if (empty($name) || empty($year_of_study) || empty($class)) {
    echo "<script type='text/javascript'>alert('Please fill all fields');</script>";
} else {
    // If a new photo is uploaded, remove the old one from the server
    if (!empty($photo)) {
        // Fetch the current photo path from the database
        $sql = "SELECT photo FROM table_the_iot_projects WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $currentPhoto = $stmt->fetch(PDO::FETCH_ASSOC)['photo'];

        // If a current photo exists, delete it from the server
        if ($currentPhoto && file_exists("uploads/$currentPhoto")) {
            unlink("uploads/$currentPhoto");
        }

        // Upload the new photo
        $photo_path = "uploads/" . basename($photo);
        if (!move_uploaded_file($photo_tmp, $photo_path)) {
            echo "<script type='text/javascript'>alert('Failed to upload photo');</script>";
            exit();
        }
    } else {
        // If no new photo, keep the current one
        $sql = "SELECT photo FROM table_the_iot_projects WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $photo_path = $stmt->fetch(PDO::FETCH_ASSOC)['photo'];
    }

    // Use a prepared statement for security
    $sql = "UPDATE table_the_iot_projects 
            SET name = :name, year_of_study = :year_of_study, class = :class, photo = :photo 
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':year_of_study', $year_of_study);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':photo', $photo_path);  // Store the full photo path

    // Execute and check
    if ($stmt->execute()) {
        echo "<script type='text/javascript'>
            alert('Student updated successfully');
            window.location.href = 'allstudent.php';
        </script>";
        exit(); // Stop further execution
    } else {
        echo "<script type='text/javascript'>alert('Failed to save data to the database');</script>";
    }
}
?>
