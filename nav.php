
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/nav.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head>
  <!-- creating a nav with a side bar pop up-->
  <body>
    <div class="click1">
      <span class="fas fa-bars"></span>
    </div>
  <!-- creating a nav with a side bar pop up-->
<nav class="sidebar">
      <div class="texts">Nav Menu</div>
<ul>
<!-- creating a dropbar for the nav bar-->
<li class="active"><a href="index.php" style="text-decoration: none">Home</a></li>
<li>
          <a href="#" class="serv-btn" style="text-decoration: none">Account
            <span class="fas fa-caret-down second"></span>
          </a>
          <ul class="serv-show">
<li><a href="Login.php" style="text-decoration: none">Login</a></li>
<li><a href="Log-out.php" style="text-decoration: none">Logout</a></li>
</ul>
</li>
<li><a href="Library.php"  style="text-decoration: none">Libray</a></li>
</ul>
</nav>

 <!-- creating a script where it will the info of nav bar will pop other information up if you click it-->   
<script>
    $('.click1').click(function(){
      $(this).toggleClass("click");
      $('.sidebar').toggleClass("show");
    });
      $('.feat-btn').click(function(){
        $('nav ul .feat-show').toggleClass("show");
        $('nav ul .first').toggleClass("rotate");
      });
      $('.serv-btn').click(function(){
        $('nav ul .serv-show').toggleClass("show1");
        $('nav ul .second').toggleClass("rotate");
      });
      $('nav ul li').click(function(){
        $(this).addClass("active").siblings().removeClass("active");
      });
    </script>

  </body>
</html>
 