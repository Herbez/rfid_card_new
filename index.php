<?php  
session_start();   
$message = "";  

require 'dbconn.php'; 

try  
{   
    if(isset($_POST["signin"]))  
    {  
        if(empty($_POST["email"]) || empty($_POST["password"]))  
        {  
            $message = 'Email and Password are required!';  
        }  
        else  
        {  
            $query = "SELECT * FROM users WHERE email = :email AND password = :password";  
            $statement = $conn->prepare($query);  
            $statement->execute(  
                array(  
                    'email'     =>     $_POST["email"],  
                    'password'  =>     $_POST["password"]  
                )  
            );  
            $count = $statement->rowCount();  
            if($count > 0)  
            {  
                $user = $statement->fetch(PDO::FETCH_ASSOC);
                $_SESSION["email"] = $_POST['email'];

                if ($user['type'] == 1) {    
                    header("location:admin/adminDash.php");
                } else {
                    header("location:admin/gateDash.php");
                }     
            }  
            else   
            {  
                $message = 'Invalid Email or Password ';  
            }  
        }  
    }  
}  
catch(PDOException $error)  
{  
    $message = $error->getMessage();  
}  
?> 



<!DOCTYPE html>
<html lang="en">  
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="shortcut icon" href="logo.png" type="image/x-icon">
  <link rel="stylesheet" href="styles.css">
  <title>UTAB - Index</title>
<style>
  #mylogo{
    width: 320px;
    height: auto;
    position: absolute;
    top: 20px;
    left: 39%;
  }
</style>
</head>
<body>
<div class="login-container">
<img src="logo3.png" alt="UTAB Logo" id="mylogo" class="logo">
    <header>
        <!-- <img src="logo.png" alt="UTAB Logo" id="logo" class="logo"> -->
        <h2 class="text-center">LOGIN</h2>
      </header>
      <small class="text-danger"> <?php  echo $message; ?> 
      </small>       
        
  <form method="POST" action="">
    <div class="form-group">
      <label for="inputEmail">Email:</label>
      <input type="email" class="form-control" name="email" placeholder="Enter your email" >
      
    </div>
    
    <div class="form-group">
      <label for="inputPassword">Password:</label>
      <input type="password" class="form-control memberEmail" name="password" placeholder="Enter your password" >
      
    </div>

    
    <button type="submit"  name="signin" class="btn btn-primary mb-6 BtnLogin">Login <i class="fas fa-sign-in-alt"></i></button>
  </form>
  <div class="sign-up mt-3">
   Don't have an account? <a href="signup.php">Create Account</a>
  </div>
  <div class="forgot-password mt-3">
    <a href="#">Forgot Password?</a>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>


