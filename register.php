<?php  
session_start();   
$message = "";  

require 'dbconn.php'; 

try  
{   
    if(isset($_POST["register"]))  
    {  
        if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"]))  
        {  
            $message = 'Name, Email, and Password are required!';  
        }  
        else  
        {  
            // Sanitize input to avoid SQL injection
            $name = htmlspecialchars($_POST["name"]);
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);

            // Check if email already exists
            $query = "SELECT * FROM users WHERE email = :email";  
            $statement = $conn->prepare($query);  
            $statement->bindParam(':email', $email);
            $statement->execute();  

            if($statement->rowCount() > 0)  
            {  
                $message = 'Email already exists!';  
            }  
            else  
            {  
                // Insert new user into the database
                $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
                $statement = $conn->prepare($query);
                $statement->bindParam(':name', $name);
                $statement->bindParam(':email', $email);
                $statement->bindParam(':password', $password);  // Hash password before storing
                

                if ($statement->execute()) {
                    echo "<script type='text/javascript'>
                        alert('registration  successfully');
                        window.location.href = 'index.php';
                    </script>";
                    exit(); // Stop further execution
                } else {
                    echo "<script type='text/javascript'>alert('Failed to register');</script>";
                }
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
  <title>UTAB - Register</title>
  <style>
    #mylogo{
      width: 320px;
      height: auto;
      position: absolute;
      top: 30px;
      left: 39%;
    }
    .login-container{
      margin-top: 100px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <img src="logo3.png" alt="UTAB Logo" id="mylogo" class="logo">
    <header>
      <h2 class="text-center">REGISTER</h2>
    </header>
    <small class="text-danger"> <?php echo $message; ?> </small>       
    
    <form method="POST" action="">
      <div class="form-group">
        <label for="inputName">Name:</label>
        <input type="text" class="form-control" name="name" placeholder="Enter your Name">
      </div>

      <div class="form-group">
        <label for="inputEmail">Email:</label>
        <input type="email" class="form-control" name="email" placeholder="Enter your email">
      </div>
    
      <div class="form-group">
        <label for="inputPassword">Password:</label>
        <input type="password" class="form-control" name="password" placeholder="Enter your password">
      </div>

      <button type="submit" name="register" class="btn btn-primary mb-6 BtnLogin">Register <i class="fas fa-user-plus"></i></button>
    </form>
    
    <div class="sign-up mt-3">
      Already have an account? <a href="index.php">Login</a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
