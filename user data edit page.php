<?php
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    $pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM table_the_iot_projects where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	Database::disconnect();
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
		}
		
		textarea {
			resize: none;
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
		</style>
		
		
		
	</head>
	
	<body>

	<h2  style="color: olive; text-align: center;">NFC-Based Student Smart Card</h2>
		
		<div class="container">
     
			<div class="center" style="margin: 0 auto; width:495px; border-style: solid; border-color: #f2f2f2;">
			
		 
			<form class="form-horizontal" action="user data edit tb.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
				<div class="control-group">
					<label class="control-label">ID</label>
					<div class="controls">
						<input name="id" type="text" placeholder="" value="<?php echo htmlspecialchars($data['id']); ?>" readonly>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Name</label>
					<div class="controls">
						<input name="name" type="text" placeholder="" value="<?php echo htmlspecialchars($data['name']); ?>" required>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Year Of Study</label>
					<div class="controls">
						<select name="year_of_study" id="mySelect" required>
							<option value="<?php echo $data['year_of_study']; ?>"><?php echo $data['year_of_study']; ?></option>
							<option value="Year 1">Year 1</option>
							<option value="Year 2">Year 2</option>
							<option value="Year 3">Year 3</option>
							
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Class</label>
					<div class="controls">
						<input name="class" type="text" placeholder="" value="<?php echo htmlspecialchars($data['class']); ?>" required>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Department</label>
					<div class="controls">
						<input name="department" type="text" placeholder="" value="<?php echo htmlspecialchars($data['department']); ?>" required>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Photo</label>
					<div class="controls">
						<input type="file" id="file-input" name="photo" class="form-control-file">
						<br>
						<!-- Display existing photo -->
						<img src="<?php echo 'uploads/' . $data['photo']; ?>" alt="Current Photo" width="100">
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="user data.php">Back</a>
				</div>
			</form>

			</div>               
		</div> <!-- /container -->	
		
		<script>
			var g = document.getElementById("defaultGender").innerHTML;
			if(g=="Male") {
				document.getElementById("mySelect").selectedIndex = "0";
			} else {
				document.getElementById("mySelect").selectedIndex = "1";
			}
		</script>
	</body>
</html>