<?php
// Initializing the session
session_start();
 
// Check if the user is already logged in, if yes then redirect the person  to home page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: work.php");
    exit;
}
 
// Including a config file to it
require_once "connection.php";
 
// Stating the variables and initialize it with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Cross checking to see if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Cross checking to see if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validating the  credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT buyer_id, username, password FROM sign_up_buyer WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Binding variables to parameters
            $stmt->bind_param("s", $param_username);
            
            // Setting parameters
            $param_username = $username;
            
            // Attempting to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;     
                            $_SESSION["firstname"] = $firstname;                       
                            
                            // Redirect user to Home page
                           
                            header("location: work.php?login=success");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password is not valid.";
                            
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "Sorry, such username doesn't exist.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Closing the connection
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/Login.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;600&display=swap" rel="stylesheet">
</head>
 <!-- calling the nav bar here. -->
<?php require "nav.php"?>
<body>
 <!--creating a login form page where it takes input from users and checks to see if the password corresponds or not -->
<div class="cont">
        <div class="form Sign-in">
        <h2>Login</h2>
        <label>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
            <input type="submit" class="submit" value="Login">
        </div>
                
            </div>
             <!-- creating a nice pic next to the Login form and creating a link for user to sign up if they don't have an account. -->
    <div class='sub-cont'>
        <div class='img'>
            <div class="img-text">
            <a href="Sign-up.php">Sign up</a>
                <h2>New here?</h2>
                <p>Click on Sign up above and discover what's best for you!</p>  
</div> 
        </div>
    </div>
</div>
</label>
</body>
</html>