<!DOCTYPE html>
    <html ml-update="aware">
    <head>
        <title>Quiz Portal</title>
        <script>
          const hideSideBar = () => {
            document.getElementById("sidebar").parentElement.removeChild(document.getElementById("sidebar"))
          }
        </script>
    </head>
    <body style="scroll-behavior: auto !important;">
    
    <div class="container wrapper">
      <div id="top">
        <h1>Welcome to RMD Quiz portal</h1>
        <p>A place where you gracefully fail</p>
      </div>
      <div class="wrapper">
       <div id="menubar">
         <ul id="menulist">
         <?php if (!isset($_SESSION['userName'])) {?>
            <a href="Login.php"><li class="menuitem" >Login</li></a>
            <a href="Register.php"><li class="menuitem" >Register</li></a>
         
         <?php } else {?>  
            <li id="UserItem" >Hello <?php echo $_SESSION['userName']?>!</li>
            <?php if ($_SESSION['userType']== 'teacher') {?>
              <a href="home.php"><li class="menuitem" >Exams</li></a>
              <a href="users.php"><li class="menuitem" >Users</li></a>
            <?php }?>
            <a href="../Logout.php"><li class="menuitem" >Logout</li></a>
          <?php } ?> 
         
          </ul>
        </div>

    </body></html>