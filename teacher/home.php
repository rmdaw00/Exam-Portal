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

if (isset($_GET['id'])){
    $formOperation = "update.php";
    $formHeader = "Edit Options for Exam #";
    $formButton = "Edit";
} else {
    $formOperation = "insert.php";
    $formHeader = "Add new Exam";
    $formButton = "Add";
}




$returnSelect = $db->query("SELECT * FROM Quiz Where teacherID = '" . $_SESSION['userID'] . "'");?>


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
                    <th>Date</th>  
                    <th>Duration</th>  
                    <th>Actions</th>
                  </tr>
      <?php
                  $id = "";
                  $title = "";
                  $duration = 0;
                  $date = "";

      while($rowArray = $returnSelect->fetch())
      {
          if (isset($_GET['id'])) {
              if ($rowArray['QuizID'] == $_GET['id']) {
                  $id = $rowArray['QuizID'];
                  $color = "#d2f7dd";
                  $title = $rowArray['title'];
                  $date = $rowArray['date'];
                  $duration = $rowArray['duration'];
                  $formHeader=$formHeader.$id;
              } else {
                  $color = "white";
              }
          }
          ?><tr style="background-color: <?php echo $color ?>;"><td><?php
          
          

          echo $rowArray['title'];
          ?></td><td><?php
          echo $rowArray['date'];
          ?></td><td><?php
          echo $rowArray['duration'];
          ?></td><td class="actioncell"><?php
          echo "<a href=\"home.php?id=".$rowArray['QuizID']. "\"><i class=\"fas fa-pen\" style=\"font-size:20px;color:green\"></i></a>";
          echo "<a href=\"exam/delete.php?id=".$rowArray['QuizID']. "\"><i class=\"fa fa-trash\" style=\"font-size:20px;color:red\"></i></a>";
          echo "<a href=\"details.php?id=".$rowArray['QuizID']. "\"><i class=\"fas fa-edit\" style=\"font-size:20px;color:green\"></i></a>";
          
          
          
      }
      ?>
      </td></tr></table>

      <form action="exam/<?php echo $formOperation ?>" method="POST" >
        <input class="formButton" type="submit" value="<?php echo $formButton ?>"/>
        <h2><?php echo $formHeader ?></h2>
        <input type="hidden" name="id" value="<?php echo $id ?>" /></br>
        <div class="question">
            <label for="name">Quiz Name:</label>
            <input id="name" type="text" name="title" value="<?php echo $title ?>" />
        </div>
        <div class="question">
            <label for="name">Quiz Date:</label>
            <input type="date" name="date" value="<?php echo $date ?>" width="40"/></br>
        </div>
        <div class="question">
            <label for="name">Quiz Duration:</label>
            <input type="number" name="duration" value="<?php echo $duration ?>" width="40"/></br>
        </div>
        
    </form>

       </div>
        <div id="sidebar">
          <i class="fa fa-trash" onclick="hideSideBar()"></i> 
          <h3>Updates</h3>
          <li>Students may cheat, is it even possible?</li>
          
        </div>
      </div>  
      
      <?php include("../footer.php")?>

    </div>
    

    
    
    
    </body></html>