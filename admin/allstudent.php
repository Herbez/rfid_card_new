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
 
    
    // Fetch all users to display in the table
    $sql_all_users = "SELECT * FROM table_the_iot_projects";
    $query_all = $conn->prepare($sql_all_users);
    $query_all->execute();
    $all_users = $query_all->fetchAll(PDO::FETCH_ASSOC); // Multiple rows

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
  <title>UTB - All Student</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <script src="jquery.min.js"></script>

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
        
        <div class="row mb-3">

            <div class="col-xl-12 col-lg-5 ">
              <div class="card">

                <div class="table-responsive">
                <table class="table align-items-center table-bordered">
                    <thead class = "text-primary">
                      <tr>
                        <th>Name</th>
                        <th>Card_Id</th>
                        <th>year_of_study</th>
                        <th>Class</th>
                        <th>Photo</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($all_users)) : ?>
                            <?php foreach ($all_users as $row) : ?>
                                <tr>
                                    <td><b><?php echo htmlspecialchars($row['name']); ?></b></td>
                                    <td><b><?php echo htmlspecialchars($row['id']); ?></b></td>
                                    <td><b><?php echo htmlspecialchars($row['year_of_study']); ?></b></td>
                                    <td><b><?php echo htmlspecialchars($row['class']); ?></b></td>
                                    <td>
                                    <?php if (!empty($row['photo'])) : ?>
                                        <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="User Photo" style="width: 100px; height: 100px; object-fit: cover;">
                                    <?php else : ?>
                                        <span>No Photo</span>
                                    <?php endif; ?>
                                    </td>
                                    <td>
                                        <!-- Edit Icon -->
                                        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- Delete Icon -->
                                        <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5">No data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>

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

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>

