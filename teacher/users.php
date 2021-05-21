<?php session_start();
if (isset($_SESSION['userName'])) {
  If ($_SESSION['userType'] == 'teacher') {
    $userName = $_SESSION['userName'];
    $userID = $_SESSION['userID'];

  }  else {
    //IS STUDENT
    header("Location: ../teacher/home.php");
    die();
    
    
  }
} else {
  //Not Logged
    header("Location: ../home.php");
    die();
}
 

$dns = "mysql:host=localhost;dbname=ExamApp";
$db = new PDO($dns, 'root', '');




$returnSelect = $db->query("SELECT * FROM Users");?>


<!DOCTYPE html>
    <html ml-update="aware">
    <head>
        <link rel="stylesheet" href="../style.css"/>
        <script src="../scripts.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <title>Quiz Portal</title>
    </head>
    <body  style="scroll-behavior: auto !important;">
    <?php include("../header.php")?>

     <div id="main">

          <?php if (isset($_GET['error'])) echo  '<span class="error">' . $_GET['error'] . '</span>' ?>
          <h1>Teachers Dashboard</h1>
                <table>
                  <tr> 
                    <th>Name</th>         
                    <th>Email</th>  
                    <th>Actions</th>  

                  </tr>
      <?php
                  $id = "";
                  $title = "";
                  $date = "";

      while($rowArray = $returnSelect->fetch())
      {
          ?><tr style="background-color: white;"><td><?php

          echo $rowArray['name'];
          ?></td><td><?php
          echo $rowArray['email'];
          ?></td><td><?php
             echo '<a class=' . ($rowArray['isTeacher']?'redable':'greenable') . ' href="users/toggleTeacher.php?id=' . $rowArray['id'] . '">' .
                  '<i class="fas fa-chalkboard-teacher" style="font-size:20px;"/></i></a>';
          echo '<a href="users/delete.php?id='.$rowArray['id']. '"><i class="fa fa-trash" style="font-size:20px;color:red"></i></a>';
          
          
          
      }
      ?>
      </td></tr></table>

    

       </div>
        <div id="sidebar">
          <i class="fa fa-trash" onclick="hideSideBar()"></i> 
          <h3>Tips</h3>
          <li>Students can become teachers in a click</li>
          <li>Students can become nobody in one click too, too much power!</li>

          <li><i class="fas fa-chalkboard-teacher" style="font-size:16px;color:green;float:none;"/></i>  is a teacher, click to toggle it</li>
          
        </div>
      </div>  
      
      <?php include("../footer.php")?>

    </div>
    

    
    
    
    </body></html>