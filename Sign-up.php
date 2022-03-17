
<?php
session_start();
// Including a config file to it
require_once "connection.php";
 
// Variable are initialize with empty values
$username = $firstname = $lastname = $phone = $email = $password = $confirm_password = "";
$username_err = $firstname_err = $lastname_err = $phone_err = $email_err= $password_err = $confirm_password_err = "";


 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validating the username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Preparing a select statement
        $sql = "SELECT buyer_id FROM sign_up_buyer WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            //Binding variables to parameters
            $stmt->bind_param("s", $param_username);
            
            // Setting parameters
            $param_username = trim($_POST["username"]);
            
            // Attempting to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already used.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Closing the statement
            $stmt->close();
        }
    }
    
    // Validating the password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validating the confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please enter your password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
     
    //validating the first name
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your first name.";
    }else{
        $firstname = trim($_POST["firstname"]);
    }

      //validating the last name
      if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter your last name.";
    }else{
        $lastname = trim($_POST["lastname"]);
    }
   
    //validating the phone number
    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter your phone number.";
        }else if (!preg_match( "/^[\W][0-9]{3}?[\s]?[0-9]{2}?[\s]?[0-9]{3}[\s]?[0-9]{4}$/", $_POST["phone"])){
            $phone_err= "please enter a valid phone number";
        }
    else{
        $phone = trim($_POST["phone"]);
    }

    // Validating the email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please your email.";
    }else if (!preg_match( "/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i", $_POST["email"])){
        $email_err= "please enter a valid email";
}   else{
        // Preparing a select statement
        $sql = "SELECT buyer_id FROM sign_up_buyer WHERE email = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            //Binding variables to parameters
            $stmt->bind_param("s", $param_email);
            
            // Setting parameters
            $param_email = trim($_POST["email"]);
            
            // Attempting to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $email_err = "This email is already used.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Closing the statement
            $stmt->close();
        }
    }
    

    //Checking the input errors before updating into the database
    if(empty($username_err) && empty($firstname_err) && empty($lastname_err) && empty($phone_err) && empty($email_eer) && empty($password_err) && empty($confirm_password_err)){
        
        // Preparing an insert statement
        $sql = "INSERT INTO sign_up_buyer (username, fname, lname, phone, email, password) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
                $_SESSION["username"] = $username;     
                $_SESSION["firstname"] =  $firstname;
                $_SESSION["lastname"] = $lastname;     
                $_SESSION["email"] = $email; 
                $_SESSION["phone"] = $phone;   
             // Setting parameters
             $param_lastname = $lastname;
             $param_firstname = $firstname;
             $param_phone = $phone;
             $param_username = $username;
             $param_email= $email;
             $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            // Binding variables to parameters
            $stmt->bind_param("ssssss", $param_username, $param_firstname, $param_lastname, $param_phone, $param_email, $param_password);
            
            
            // Attempting to execute the prepared statement
            if($stmt->execute()){  
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            
            }

            // Closing the statement
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
    <title>Sign up</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/Signup.css">
</head>
<body>
<!-- calling the nav bar here. -->
<?php require "nav.php";?>
<!--creating a sign up form page where it takes input from users and checks to see if the password corresponds or not -->
    <div class="cont">
        <div id='formcontainer'>
            <div id="Heading">
                <header id="header">Create Account</header>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span>   
             </div>
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $lastname_err; ?></span>   
            </div>
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone</label>
                <input type="tel" name="phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>   
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>   
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
                <!-- creating a submit button where it confirms everything and then takes the user to the login page. -->
                <div id="ee">
                    <button name='submit' id="submit">Get Started</button>
                    <div id="tandc">
                        By clicking this button you are agreeing to the
                        <a href=""><br>terms and conditions</a>
                    </div>
                </div>
            </form>
        </div>
      
</body>
</html>