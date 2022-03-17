<?php session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>    
</head>
<body>
<?php require "nav.php"?>
<div class="work">
   <p> Welcome <?php echo $_SESSION["lastname"]; echo " "; echo $_SESSION["firstname"];?></p>
   
    <p></i></p>
</div>


<style>
    .work{
        position:absolute;
        font-size:30px;
        left:30%;
        top:30%;

    }
</style>
</body>
</html>
