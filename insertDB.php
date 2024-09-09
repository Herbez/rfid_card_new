

<?php
require('dbconn.php');

    
        $name = $_POST['name'] ?? '';
        $id = $_POST['id'] ?? '';
        $year_of_study = $_POST['year_of_study'] ?? '';
		$class = $_POST['class'] ?? '';
		$department = $_POST['department'] ?? '';
        $photo = $_FILES['photo']['name'] ?? '';
        $photo_tmp = $_FILES['photo']['tmp_name'] ?? '';
    
        if (empty($name) || empty($id) || empty($year_of_study) || empty($class) || empty($department)  || empty($photo)) {
            echo "<script type='text/javascript'>alert('Please fill all fields')</script>";
        } else {
            // Upload photo to the server (ensure the 'uploads' directory exists)
            if (move_uploaded_file($photo_tmp, "uploads/" . $photo)) {
                // Insert data into the database
                $sql = "INSERT INTO table_the_iot_projects (name, id, year_of_study, class,department, photo)
                        VALUES ('$name', '$id', '$year_of_study','$class' ,'$department',  '$photo')";
    
                if ($conn->query($sql) === TRUE) {
                    
					header("Location: user data.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "<script type='text/javascript'>alert('Failed to upload photo')</script>";
            }
        }


?>	