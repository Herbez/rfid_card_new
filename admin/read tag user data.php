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
	
	$msg = null;
	if ($data=== false) {
		$msg = "Dear student, you are not registered yet.ask for a help !!!";
		$data['id']=$id;
		$data['name']="--------";
		$data['year_of_study']="--------";
		$data['class']="--------";
		$data['photo']="--------";
	} else {
		$msg = null;
	}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  	<link href="css/ruang-admin.min.css" rel="stylesheet">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/ruang-admin.min.js"></script>
	<style>
		td.lf {
			padding-left: 15px;
			padding-top: 12px;
			padding-bottom: 12px;
		}
	</style>
</head>
 
	<body>	
		<div>
			<form>
				<table  width="452" border="1" bordercolor="#10a0c5" align="center"  cellpadding="0" cellspacing="1"  bgcolor="#000" style="padding: 2px">
					<tr>
						<td  height="40" align="center"  bgcolor="#10a0c5"><font  color="#FFFFFF">
						<b>WELCOME STUDENT!</b></font></td>
					</tr>
					
					<tr>
						
						<td bgcolor="#f9f9f9">
							<table width="452"  border="0" align="center" cellpadding="5"  cellspacing="0">
							<tr >
								<img src="uploads/<?php echo $data['photo']; ?>" alt="Student Photo" 
								class="img-fluid rounded" id="student-photo" 
								style="width: 160px; height: 160px;">
							</tr>
								<tr>
									<td width="113" align="left" class="lf">Card ID</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['id'];?></td>
								</tr>

								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Name</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['name'];?></td>
								</tr>
								<!--<tr>
									<td align="left" class="lf">Year Of Study</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['year_of_study'];?></td>
								</tr> -->
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Class</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['class'];?></td>
								</tr>
								<!-- <tr>
									<td align="left" class="lf">Department</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['department'];?></td>
								</tr> -->

							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<p style="color:red;"><?php echo $msg;?></p>
	</body>
</html>