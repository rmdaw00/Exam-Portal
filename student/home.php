<?php session_start();
if (isset($_SESSION['userName'])) {
  If ($_SESSION['userType'] == 'teacher') {
    //IS Teacher
    header("Location: ../teacher/home.php");
    die();

  } else {
    //IS STUDENT
    $userName = $_SESSION['userName'];
    $userID = $_SESSION['userID'];
    
  }
} else {
  //Not Logged
    header("Location: ../home.php");
    die();
}
$dns = "mysql:host=localhost;dbname=ExamApp";
$db = new PDO($dns, 'root', '');

$returnSelect = $db->query("SELECT *, sum(mark) AS TotalMarks, sum(maxMark) AS MaxMarks FROM Quiz 
                              JOIN Users ON Users.id = Quiz.teacherID
                              LEFT JOIN Mark ON Quiz.QuizID = Mark.quizID Where Mark.userID = '" . $_SESSION['userID'] . "'");




?>

<!DOCTYPE html>
    <html ml-update="aware">
    <head>
        <link rel="stylesheet" href="../style.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <script src="../scripts.js"></script>
        <title>Quiz Portal</title>
    </head>
    <body  style="scroll-behavior: auto !important;">
    <?php include("../header.php")?>

     <div id="main">
          <h1>Student DashBoard</h1>
        
          <?php if (isset($_GET['error'])) echo  '<span class="error">' . $_GET['error'] . '</span>' ?>

          <table>
                  <tr> 
                    <th>Quiz</th>         
                    <th>Teacher</th>  
                    <th>Available Date</th>  
                    <th>Max Mark</th>  
                    <th>Mark</th>  
                    <th>Date Taken</th>  
                    <th>Actions</th>
                  </tr>

          <?php $returnSelect = $db->query('SELECT *, (Quiz.date<CURRENT_DATE) AS Available, SUM(Question.marks) AS MaxMarks FROM Quiz 
                                                JOIN Users ON Users.id = Quiz.teacherID 
                                                LEFT JOIN Question ON Quiz.QuizID = Question.quizID 
                                                LEFT JOIN Mark ON Quiz.QuizID = Mark.quizID 

                                                Group By Quiz.QuizID 
                                                having Mark.userID IS NULL OR Mark.userID =' . $_SESSION['userID'] );
                              
                              
                              while($rowArray = $returnSelect->fetch())
                              {

                                  ?><tr style="background-color: white;"><td><?php
                                  echo $rowArray['title'];
                                  ?></td><td><?php
                                  echo $rowArray['name'];

                                  ?></td><td><?php
                                  echo $rowArray['date'];

                                  ?></td><td><?php
                                  echo $rowArray['MaxMarks'];

                                  ?></td><td><?php
                                  echo $rowArray['mark'];

                                  ?></td><td><?php
                                  echo $rowArray['dateTaken'];

                                  ?></td><td class="actioncell"><?php
                                  if ($rowArray['Available'] && empty($rowArray['dateTaken']) && !empty($rowArray['MaxMarks'])) echo "<a href=\"quiz.php?id=".$rowArray['QuizID']. "\"><i class=\"fas fa-arrow-circle-right\" style=\"font-size:20px;color:green\"></i></a>";
                                  
                                  
                                  
                              }
                              ?>
                              </td></tr></table>
       </div>
        <div id="sidebar">
          <i class="fa fa-trash" onclick="hideSideBar()"></i> 
          <h3>Tips</h3>
          <li>You can take exams when they are due, no deadlines, its only positive education, you only have limited time to complete the test, but you can prepare as long as you want </li>
          
        </div>
      </div>  
      
      <?php include("../footer.php")?>

    </div>
    

    
    
    
    </body></html>