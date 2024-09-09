<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html lang="en">
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="login/images/smart-id.png" rel="icon">
		<script src="js/bootstrap.min.js"></script>
		<style>
		html {
			font-family: Arial;
			display: inline-block;
			margin: 0px auto;
			text-align: center;
		}

		ul.topnav {
			list-style-type: none;
			margin: auto;
			padding: 0;
			overflow: hidden;
			background-color: #4CAF50;
			width: 70%;
		}

		ul.topnav li {float: left;}

		ul.topnav li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		ul.topnav li a:hover:not(.active) {background-color: #3e8e41;}

		ul.topnav li a.active {background-color: #333;}

		ul.topnav li.right {float: right;}

		@media screen and (max-width: 600px) {
			ul.topnav li.right, 
			ul.topnav li {float: none;}
		}
		
		.table {
			margin: auto;
			width: 90%; 
		}
		
		thead {
			color: #FFFFFF;
		}
		
		</style>
		
		<title>NFC-Based Student Smart Card</title>
	</head>
	
	<body>
	<h2 style="color: olive;">NFC-Based Student Smart Card</h2>
		<ul class="topnav">
			<li><a href="index.php">Home</a></li>
			<li><a  href="user data.php">Students Data</a></li>
			<li><a href="registration.php">Registration</a></li>
			<li><a class="active" href="report.php">Report</a></li>
			<li id="logout"style="float: right; background-color: red; ">
			<a  href="login/logout.php">Logout</a></li>
		</ul>
		<br>
		<div class="container">
            <div class="row">
                <h3 style="text-center">Students Data Table</h3>

            </div>
            <div class="text-center" style="margin-bottom: 10px;">
                <a href="generate_pdf.php" style="padding: 10px;" class="btn btn-primary">Download PDF Report</a>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>

                    <tr bgcolor="#10a0c5" color="#FFFFFF">
                      <th>Name</th>
                      <th>Card ID</th>
					  <th>Year Of Study</th>
					  <th>Class</th>
                      <th>Department</th>
                      <th>Photo</th>
					  <th>Check Time</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * 
                    FROM table_the_iot_projects t
                    LEFT JOIN report r 
                    ON t.id = r.sid ORDER BY datetime DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['sid'] . '</td>';
                            echo '<td>'. $row['year_of_study'] . '</td>';
							echo '<td>'. $row['class'] . '</td>';
							echo '<td>'. $row['department'] . '</td>';
							echo '<td><img src="uploads/' . $row['photo'] . '" alt="Student Photo" style="width:25px; height:auto;"></td>';
                            echo '<td>'. $row['datetime'] . '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
				</table>
			</div>
		</div> <!-- /container -->
	</body>
</html>