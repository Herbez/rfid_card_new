<?php 
session_start();  

require 'dbconn.php'; 

// Get the student ID from the query parameter
$id = $_GET['id'] ?? '';

if (!isset($_SESSION["email"])) {
  header("Location: ../index.php"); 
  exit();
}

$userid=$_SESSION["email"];
 if(isset($_SESSION["email"]))  
 {  
  $sql="SELECT * FROM users WHERE email = ?";
  $query=$conn->prepare($sql);
  $query->execute(array($userid));
  $results=$query->fetchAll(PDO::FETCH_OBJ);
   if($query->rowCount()>0){
    foreach ($results as $result) {
       $result->name;
       
    }
  }
  
  }  
 

$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
file_put_contents('UIDContainer.php',$Write);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo.png" rel="icon">
  <title>UTB - Edit Student</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <script src="jquery.min.js"></script>
  <script>
      $(document).ready(function(){
           $("#getUID").load("UIDContainer.php");
          setInterval(function() {
              $("#getUID").load("UIDContainer.php");
          }, 500);
      });
  </script>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
      <?php
      include('components/sidebar.php');
      ?>

    <!-- End of Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php
        include('components/topbar.php')
        ?>

        <!-- End of TopBar   -->

        <?php    
        // Get the student ID from the query parameter
            $id = $_GET['id'] ?? '';

            // Prepare the SQL query to select data from the table
            $sql = "SELECT * FROM table_the_iot_projects WHERE id = :id";
            $stmt = $conn->prepare($sql);
            
            // Bind the ID parameter to the query
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            
            // Execute the query
            $stmt->execute();
            
            // Fetch the results
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Assign row values to variables
                    $id = $row['id'];
                    $name = $row['name'];
                    $class = $row['class'];
                    $year_of_study = $row['year_of_study'];
                    $photo = $row['photo'];
            ?>
            <form  method="post" enctype="multipart/form-data" id="studentForm">
                <!-- Card ID Field -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">Card ID</label>
                    <div class="col-sm-7">
                        <input  
                            name="id" 
                            id="getUID" 
                            class="form-control" 
                            placeholder="Please Scan your Card / Key Chain to display ID" 
                            rows="1" cols="1" 
                            value="<?php echo $row['id'];?>"
                            disabled
                            required>
                        <small class="text-danger validation-message" id="cardIdMessage"></small>
                    </div>
                </div>

                <!-- Name Field -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">Name</label>
                    <div class="col-sm-7">
                        <input 
                            type="text" 
                            class="form-control" 
                            name="name" 
                            value="<?php echo $row['name'];?>"
                            placeholder="Enter Student Name" 
                            style="width: 655px;" 
                            pattern="[A-Za-z\s]+" 
                            title="Name must contain only letters and spaces." 
                            required>
                        <small class="text-danger validation-message" id="nameMessage"></small>
                    </div>
                </div>

                <!-- Class Field -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">Class Name</label>
                    <div class="col-sm-9">
                        <input 
                            type="text" 
                            class="form-control" 
                            name="class" 
                            value="<?php echo $row['class'];?>"
                            placeholder="Class Name" 
                            style="width: 655px;"
                            pattern="[A-Za-z\s]+" 
                            title="Class name must contain only letters and spaces." 
                            required>
                        <small class="text-danger validation-message" id="classMessage"></small>
                    </div>
                </div>

                <!-- Year of Study Field -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">Year of study</label>
                    <div class="col-sm-7">
                        <select name="year_of_study" class="form-control">
                            <option value="Year 4" <?= $row['year_of_study'] === 'Year 4' ? 'selected' : ''; ?>>Year 4</option>
                            <option value="Year 3" <?= $row['year_of_study'] === 'Year 3' ? 'selected' : ''; ?>>Year 3</option>
                            <option value="Year 2" <?= $row['year_of_study'] === 'Year 2' ? 'selected' : ''; ?>>Year 2</option>
                            <option value="Year 1" <?= $row['year_of_study'] === 'Year 1' ? 'selected' : ''; ?>>Year 1</option>
                        </select>
                    </div>
                </div>


                <!-- Photo Upload Field -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right"></label>
                    <div class="col-sm-9">
                        <!-- Display the current photo if available -->
                        <?php if(!empty($row['photo'])): ?>
                            <img src="uploads/<?php echo $row['photo']; ?>" alt="Current Photo" class="img-thumbnail mb-2" style="max-width: 100px;">
                        <?php endif; ?>
                        
                        <!-- File input field -->
                        <input type="file" id="file-input" name="photo" class="form-control-file" required>
                        <small class="text-danger validation-message" id="photoMessage" ></small>
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="form-group row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <button type="submit" name="updatecard" class="btn btn-primary">Update Card</button>
                    </div>
                </div>
            </form>
            <?php                }
            } else {
                echo "<p>No record found for ID: $id</p>";
            }    
        ?>

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
        
        <!-- content -->
        
        <div class="card-body">

        </div>

        </div>
        
        <!-- End Of Content -->

      </div>
      <!-- Footer -->
      <?php
      include('components/footer.php')
      ?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script>
    document.getElementById('studentForm').addEventListener('submit', function (e) {
    let isValid = true;

    // Name Validation
    const name = document.querySelector('[name="name"]');
    if (!/^[A-Za-z\s]+$/.test(name.value)) {
        document.getElementById('nameMessage').innerText = "Name must contain only letters and spaces.";
        isValid = false;
    } else {
        document.getElementById('nameMessage').innerText = "";
    }

    // Class Validation
    const className = document.querySelector('[name="class"]');
    if (!/^[A-Za-z\s]+$/.test(className.value)) {
        document.getElementById('classMessage').innerText = "Class name must contain only letters and spaces.";
        isValid = false;
    } else {
        document.getElementById('classMessage').innerText = "";
    }

    // Prevent Form Submission if Validation Fails
    if (!isValid) {
        e.preventDefault();
    }
});

  </script>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>

<?php
require('dbconn.php');

if (isset($_POST['updatecard'])) {
    $id = $_GET['id'];
    $name = $_POST['name'];
    $year_of_study = $_POST['year_of_study'];
    $photo = $_FILES['photo']['name'];

    // Move uploaded file to the uploads folder
    if (!empty($photo)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
    }

    // Update query
    $sql = "UPDATE table_the_iot_projects SET name = :name, year_of_study = :year_of_study, photo = :photo WHERE id = :id";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':year_of_study', $year_of_study);
    $stmt->bindParam(':photo', $photo);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "<script type='text/javascript'> alert('Student Card Updated');
            window.location.href='allstudent.php';
        </script>";
        exit();
    } else {
        echo "<script type='text/javascript'>alert('Student Card Not Updated');</script>";
        header("Refresh:0.01; url=allstudent.php");
        exit();
    }
}
?>
