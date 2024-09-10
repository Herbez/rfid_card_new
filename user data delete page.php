<?php
    require 'database.php';
    $id = 0;
     
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
         
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        try {
            // Begin transaction
            $pdo->beginTransaction();
        
            // First, delete from the child table `report`
            $sql = "DELETE FROM report WHERE sid = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
        
            // Now, delete from the parent table `table_the_iot_projects`
            $sql = "DELETE FROM table_the_iot_projects WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
        
            // Commit transaction
            $pdo->commit();
        
            // Redirect to the data page
            header("Location: user data.php");
        } catch (Exception $e) {
            // Rollback in case of an error
            $pdo->rollBack();
            echo "Failed: " . $e->getMessage();
        }
        
        Database::disconnect();    
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <link href="login/images/smart-id.png" rel="icon">
    <script src="js/bootstrap.min.js"></script>
	<title>NFC-Based Student Smart Card</title>
</head>
 
<body>
<h2  style="color: olive; text-align: center;">NFC-Based Student Smart Card</h2>

    <div class="container">
     
		<div class="span10 offset1">
			<div class="row">
				<h3 align="center">Delete User</h3>
			</div>

			<form class="form-horizontal" action="user data delete page.php" method="post">
				<input type="hidden" name="id" value="<?php echo $id;?>"/>
				<p class="alert alert-error">Are you sure to delete ?</p>
				<div class="form-actions">
					<button type="submit" class="btn btn-danger">Yes</button>
					<a class="btn" href="user data.php">No</a>
				</div>
			</form>
		</div>
                 
    </div> <!-- /container -->
  </body>
</html>