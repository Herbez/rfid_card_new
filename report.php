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
			html { font-family: Arial; display: inline-block; margin: 0px auto; text-align: center; }
			ul.topnav { list-style-type: none; margin: auto; padding: 0; overflow: hidden; background-color: #4CAF50; width: 70%; }
			ul.topnav li { float: left; }
			ul.topnav li a { display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; }
			ul.topnav li a:hover:not(.active) { background-color: #3e8e41; }
			ul.topnav li a.active { background-color: #333; }
			ul.topnav li.right { float: right; }
			@media screen and (max-width: 600px) { ul.topnav li.right, ul.topnav li { float: none; } }
			.table { margin: auto; width: 90%; }
			thead { color: #FFFFFF; }
		</style>
		
		<title>Student RFID_Card</title>
	</head>
	
	<body>
		<!-- <h2 align="center">ACCESS WAVE CSTroll</h2> -->
		<h2  style="text-align: center;">Student RFID_Card</h2>
		<ul class="topnav">
			<!-- <li><a href="index.php">Home</a></li> -->
			<li><a href="user data.php">Students Data</a></li>
			<li><a  href="registration.php">Registration</a></li>
			<li><a href="read tag.php">Read Card</a></li>
			<li><a class="active" href="report.php">Attendance</a></li>
			<!-- <li id="logout"style="float: right; background-color: red; ">
			<a  href="login/logout.php">Logout</a></li> -->
		</ul>
		<br>

		<!-- Filter Form -->
		<div class="container">
			<h3 style="text-center">Filter by Date</h3>
			<form action="report.php" method="get">
				<label for="filter">Select Date:</label>
				<input type="date" name="selected_date" required>
				<button type="submit" class="btn btn-primary">View Report</button>
			</form>
			<br>

			<div class="row">
				<h3 style="text-center">Students Data Table</h3>
			</div>
			
			<div class="row">
				<table class="table table-striped table-bordered">
				  <thead>
					<tr bgcolor="#10a0c5" color="#FFFFFF">
					  <th>Name</th>
					  <th>Card ID</th>
					  <!-- <th>Year Of Study</th> -->
					  <th>Class</th>
					  <!-- <th>Department</th> -->
					  <th>Photo</th>
					  <th>Check Time</th>
					  <th>Status</th>

					</tr>
				  </thead>
				  <tbody>
				  <?php
				   include 'database.php';
				   $pdo = Database::connect();

				   
					if (isset($_GET['selected_date'])) {
						$selected_date = $_GET['selected_date'];

						// Query to fetch all students with their attendance for the selected date
						$sql = "SELECT t.id AS sid, t.name, t.class, t.photo, r.datetime 
								FROM table_the_iot_projects t
								LEFT JOIN report r ON t.id = r.sid AND DATE(r.datetime) = ?
								ORDER BY t.name";

						$q = $pdo->prepare($sql);
						$q->execute([$selected_date]);
						$records = $q->fetchAll(PDO::FETCH_ASSOC);

						if (count($records) > 0) {
							foreach ($records as $row) {
								echo '<tr>';
								echo '<td>' . htmlspecialchars($row['name']) . '</td>';
								echo '<td>' . htmlspecialchars($row['sid']) . '</td>';
								echo '<td>' . htmlspecialchars($row['class']) . '</td>';
								echo '<td><img src="uploads/' . htmlspecialchars($row['photo']) . '" alt="Student Photo" style="width:25px; height:auto;"></td>';
								echo '<td>' . ($row['datetime'] ? htmlspecialchars($row['datetime']) : '-----') . '</td>';
								
								// Logic to check if the student is present or absent
								if (!empty($row['datetime'])) {
									echo '<td style="color: green;">Present</td>';
								} else {
									echo '<td style="color: red;">Absent</td>';
								}

								echo '</tr>';
							}
						} else {
							// No data found message
							echo '<tr><td colspan="7">No report found for the selected date.</td></tr>';
						}
					} else {
						echo '<tr><td colspan="7">Please select a date to view the report.</td></tr>';
					}
					


				   Database::disconnect();
				  ?>
				  </tbody>
				</table>
			</div>
		</div>
	</body>
</html>
