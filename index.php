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
		.logout a:hover {
			background-color: #333;
			color: white;
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
		
		img {
			size:cover;
			display: block;
			margin-left: auto;
			margin-right: auto;
			width: auto; /* Set image width to 100% */
			max-height: 60vh; /* Limit image height */
			background: 
		}



		.bottom-text {
			position: absolute;
			bottom: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			color: #666; /* Desired color */
			font-style: italic;
			font-size: small;
		}

		body{
			background-image:url("/home_ok.jpg"),
		}

		</style>
		
		<title> NFC-Based Student Smart Card</title>
	</head>
	
	<body>
		<h2 style="color: olive;">NFC-Based Student Smart Card</h2>
		<!-- <h3 style="font-style: italic; color: olive;">"Invest in your mind, it pays the best interest." - Benjamin Franklin</h3> -->
		<ul class="topnav">
			<li><a class="active" href="index.php">Home</a></li>
			<li><a href="user data.php">Student Data</a></li>
			<li><a href="registration.php">Registration</a></li>
			<li><a href="report.php">Report</a></li>
			<!-- <li><a href="read tag.php">Student's Info</a></li> -->
			<li id="logout"style="float: right; background-color: red; ">
			<a  href="login/logout.php">Logout</a></li>
		</ul>
		<br>
		<h3>Welcome to RP-Musanze College</h3>
		
		<img src="img/rpmusanze.jpg" alt="">
		
		<!-- <div class="bottom-text">Powered by Giant Electronics group</div> -->
	</body>
</html>
