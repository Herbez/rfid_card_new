<?php 
session_start();  

require 'dbconn.php'; 

if (!isset($_SESSION["email"])) {
  header("Location:../index.php"); 
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
  <title>UTB - Gate Keeper</title>
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
  <style>
    /* Custom Table Styles */
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      font-size: 18px;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #007bff;
      color: white;
      font-weight: bold;
    }

    td {
      background-color: #f9f9f9;
      border-bottom: 1px solid #ddd;
    }

    tr:nth-child(even) td {
      background-color: #f2f2f2;
    }

    .btn {
      background-color: #10a0c5;
      color: white;
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #007b8f;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
      <?php
      include('components/gatesidebar.php');
      ?>

    <!-- End of Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php
        include('components/topbar.php')
        ?>

        <!-- End of TopBar -->
     
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
        
        <div class="card-body">
        <p id="getUID" hidden></p>
		
		<br>
		
		<div id="show_user_data">
			<form>
				<table>
					<tr class="card-header text-white  bg-primary">
						<th colspan="3"><h4 class="mb-0">TAP STUDENT CARD</h4></th>
					</tr>
					
					<tr>
						<td>ID</td>
						<td>:</td>
						<td>--------</td>
					</tr>
					
					<tr>
						<td>Name</td>
						<td>:</td>
						<td>--------</td>
					</tr>

					<tr>
						<td>Year Of Study</td>
						<td>:</td>
						<td>--------</td>
					</tr>

					<tr>
						<td>Class</td>
						<td>:</td>
						<td>--------</td>
					</tr>

				</table>
			</form>
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


  </script>
  		<script>
			var myVar = setInterval(myTimer, 1000);
			var myVar1 = setInterval(myTimer1, 1000);
			var oldID="";
			clearInterval(myVar1);

			function myTimer() {
				var getID=document.getElementById("getUID").innerHTML;
				oldID=getID;
				if(getID!="") {
					myVar1 = setInterval(myTimer1, 500);
					showUser(getID);
					clearInterval(myVar);
				}
			}
			
			function myTimer1() {
				var getID=document.getElementById("getUID").innerHTML;
				if(oldID!=getID) {
					myVar = setInterval(myTimer, 500);
					clearInterval(myVar1);
				}
			}
			
			function showUser(str) {
				if (str == "") {
					document.getElementById("show_user_data").innerHTML = "";
					return;
				} else {
					if (window.XMLHttpRequest) {
						xmlhttp = new XMLHttpRequest();
					} else {
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("show_user_data").innerHTML = this.responseText;
						}
					};
					xmlhttp.open("GET","read tag user.php?id="+str,true);
					xmlhttp.send();
				}
			}
			
			var blink = document.getElementById('blink');
			setInterval(function() {
				blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
			}, 750); 
		</script>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>
