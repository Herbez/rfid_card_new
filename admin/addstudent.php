<?php 
session_start();  

require 'dbconn.php'; 

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
  <title>UTB - Add Student</title>
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

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
        
        <!-- content -->
        
        <div class="card-body">
            <form action="insertDB.php" method="post" enctype="multipart/form-data" id="studentForm">
                <!-- Card ID Field -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">Card ID</label>
                    <div class="col-sm-7">
                        <textarea 
                            name="id" 
                            id="getUID" 
                            class="form-control" 
                            placeholder="Please Scan your Card / Key Chain to display ID" 
                            rows="1" cols="1" 
            
                            required></textarea>
                        <small class="text-danger validation-message" id="cardIdMessage"></small>
                    </div>
                </div>

                <!-- Name Field -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">Name</label>
                    <div class="col-sm-9">
                        <input 
                            type="text" 
                            class="form-control" 
                            name="name" 
                            placeholder="Enter Student Name" 
                            style="width: 600px;" 
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
                            placeholder="Class Name" 
                            style="width: 600px;" 
                            pattern="[A-Za-z\s]+" 
                            title="Class name must contain only letters and spaces." 
                            required>
                        <small class="text-danger validation-message" id="classMessage"></small>
                    </div>
                </div>

                <!-- Year of Study Field -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">Year Of Study</label>
                    <div class="col-sm-7">
                        <select name="year_of_study" class="form-control">
                            <option value="Year 4">Year 4</option>
                            <option value="Year 3">Year 3</option>
                            <option value="Year 2">Year 2</option>
                            <option value="Year 1">Year 1</option>
                        </select>
                    </div>
                </div>

                <!-- Photo Upload Field -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">Photo</label>
                    <div class="col-sm-9">
                        <input type="file" id="file-input" name="photo" class="form-control-file" required>
                        <small class="text-danger validation-message" id="photoMessage"></small>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <button type="submit" name="addcard" class="btn btn-primary">Add Card</button>
                    </div>
                </div>
            </form>
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

