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
 
// Function to get the count of users
function getUserCount($conn) {
  $query = "SELECT COUNT(*) AS userCount FROM users";
  $stmt = $conn->query($query);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
  return ($row) ? $row['userCount'] : 0;
}


// Example usage
$userCount = getUserCount($conn);

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
  <title>UTB - Dashboard</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  
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
          <?php
          include('components/cont-fluid.php')
          ?>
          
        <!---Container Fluid-->
        </div>
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

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>

