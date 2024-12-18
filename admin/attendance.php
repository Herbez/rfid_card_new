<?php
session_start();  

require 'dbconn.php'; 

if (!isset($_SESSION["email"])) {
  header("Location: ../auth/index.php"); 
  exit();
}

$userid = $_SESSION["email"];

if(isset($_SESSION["email"])) {  
  // Fetch the logged-in user details
  $sql = "SELECT * FROM users WHERE email = ?";
  $query = $conn->prepare($sql);
  $query->execute(array($userid));
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() > 0) {
    foreach ($results as $result) {
      $result->name;
    }
  }
}

// Fetch all reports to display the students' report data
$sql_all_users = "SELECT t.name, t.year_of_study, t.class, t.photo, r.datetime, r.sid, r.id
                  FROM report r
                  JOIN table_the_iot_projects t ON t.id = r.sid
                  ORDER BY r.datetime DESC";
$query_all = $conn->prepare($sql_all_users);
$query_all->execute();
$all_users = $query_all->fetchAll(PDO::FETCH_ASSOC); // Multiple rows

// Check the card ID and set the status
if (isset($_POST['UIDresult'])) {
  $card_num = $_POST['UIDresult'];

  // Check if the card ID is odd or even
  $status = ($card_num % 2 == 0) ? 'Check Out' : 'Check In'; // Odd -> Check In, Even -> Check Out

  // Insert the new status into the report table
  $sql_insert_status = "INSERT INTO report (sid, status) VALUES (?, ?)";
  $insert_stmt = $conn->prepare($sql_insert_status);
  $insert_stmt->execute([$card_num, $status]);
}

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
  <title>UTB - Attendance</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
    /* Define colors for Check In and Check Out */
    .check-in {
      color: green;
    }
    .check-out {
      color: red;
    }
  </style>
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
        include('components/topbar.php');
        ?>
        <!-- End of TopBar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
        <div class="row mb-3">
              <div class="col-xl-12 col-lg-5">
                <a href="generate_report.php" class="btn btn-primary mb-3">Generate Report</a>
              </div>
          </div>
          <div class="row mb-3">
            <div class="col-xl-12 col-lg-5">
              <div class="card">
                <div class="table-responsive">
                  <table class="table align-items-center table-bordered">
                    <thead class="text-primary">
                      <tr>
                        <th>Name</th>
                        <th>Card_Id</th>
                        <th>year_of_study</th>
                        <th>Class</th>
                        <th>Photo</th>
                        <th>date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($all_users)) : ?>
                        <?php foreach ($all_users as $row) : ?>
                          <tr>
                            <td><b><?php echo htmlspecialchars($row['name']); ?></b></td>
                            <td><b><?php echo htmlspecialchars($row['sid']); ?></b></td>
                            <td><b><?php echo htmlspecialchars($row['year_of_study']); ?></b></td>
                            <td><b><?php echo htmlspecialchars($row['class']); ?></b></td>
                            <td>
                              <?php if (!empty($row['photo'])) : ?>
                                <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="User Photo" style="width: 30px; height: 30px; object-fit: cover;">
                              <?php else : ?>
                                <span>No Photo</span>
                              <?php endif; ?>
                            </td>
                            <td><b><?php echo htmlspecialchars($row['datetime']); ?></b></td>
                            <td>
                              <b class="<?php echo ($row['id'] % 2 == 0) ? 'check-out' : 'check-in'; ?>">
                                <?php echo htmlspecialchars(($row['id'] % 2 == 0) ? 'Check Out' : 'Check In'); ?>
                              </b>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <tr>
                          <td colspan="7">No data available.</td>
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
      include('components/footer.php');
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
