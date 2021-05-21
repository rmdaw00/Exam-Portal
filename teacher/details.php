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

if (isset($_GET['qid'])){
  $formOperation = "update.php";
  $formHeader = "Edit Options for Question #";
  $formButton = "Edit";
} else {
  $formOperation = "insert.php";
  $formHeader = "Add new Question";
  $formButton = "Add";
}


if (!isset($_GET['id'])) {header("Location: home.php?error=Quiz ID not supplied"); die();}


$returnfirstSelect = $db->query('SELECT *, count(QuestionID) AS Count , IFNULL(sum(marks),0) AS MarksTotal FROM Quiz LEFT JOIN Question USING (QuizID) Where quizID = ' . $_GET['id'] . ' LIMIT 1');
while($rowArray = $returnfirstSelect->fetch())
{
  $id = $_GET['id'];
  $count = $rowArray['Count'];
  $title = $rowArray['title'];
  $date = $rowArray['date'];
  $MarksTotal = $rowArray['MarksTotal'];
}

?>



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
    <?php include("../shared/questionfx.php")?>

     <div id="main">

          <?php if (isset($_GET['error'])) echo  '<span class="error">' . $_GET['error'] . '</span>' ?>
          <h1>Quiz Details</h1>
          <button class="formButton" type="button" onclick="scrollToElement('questionForm')">Scroll To Form</button>
          <div class="quizDetails">
            <div><strong>Title:</strong> <?php echo$title?></div>
            <div><strong>Date:</strong> <?php echo $date?></div>
            <div><strong>Total Questions:</strong> <?php echo$count?></div>
            <div><strong>Total Marks:</strong> <?php echo $MarksTotal?></div>
          </div>



                <table>
                  <tr> 
                    <th>Q No</th>         
                    <th>Question</th>
                    <th>Actions</th>
                  </tr>
      <?php
                  $quetionID = $answer = 0;
                  $text = $option1 =$option2 =$option3 =$option4 ="" ;
                  $questionNo = $marks = 1;


      $returnSelect = $db->query("SELECT * FROM Quiz JOIN Question USING (QuizID) WHERE quizID = " . $_GET['id'] );
      while($rowArray = $returnSelect->fetch())
      {
        if (isset($_GET['qid'])) {
          if ($rowArray['QuestionID'] == $_GET['qid']) {
              $qid = $rowArray['QuestionID'];
              $color = "#d2f7dd";
              $text = $rowArray['text'];
              $answer = $rowArray['Answer'];
              $option1 = $rowArray['option1'];
              $option2 = $rowArray['option2'];
              $option3 = $rowArray['option3'];
              $option4 = $rowArray['option4'];
              $marks=  $rowArray['marks'];
              $formHeader=$formHeader.$qid;
          } else {
              $color = "white";
          }
        }
        ?><tr style="background-color: <?php echo $color ?>;"><td><?php
          
          echo $questionNo++;
          
        
          ?></td><td><?php
          echo questionToHTML($rowArray['QuestionID'],$rowArray['marks'],$rowArray['text'],$rowArray['option1'],$rowArray['option2'],$rowArray['option3'],$rowArray['option4'],$rowArray['Answer']);

          ?></td><td class="actioncell"><?php
          echo "<a href=\"details.php?id=".$id. "&qid=" . $rowArray['QuestionID'] ."#questionForm\"><i class=\"fas fa-pen\" style=\"font-size:20px;color:green\"></i></a>";
          echo "<a href=\"question/delete.php?id=".$id."&qid=".$rowArray['QuestionID']. "\"><i class=\"fa fa-trash\" style=\"font-size:20px;color:red\"></i></a>";
        
          
          
          
      }
      ?>
      </td></tr></table>
      <form action="question/<?php echo $formOperation ?>" method="POST" id="questionForm" >
              <input class="formButton" type="submit" value="<?php echo $formButton ?>"/>
              <h2><?php echo $formHeader ?></h2>
              <input type="hidden" name="id" value="<?php echo $id ?>" />
              <input type="hidden" name="qid" value="<?php echo $qid ?>" />

              <label >Question text:</label>
              <div class="question">
                  <label>Marks:</label>
                  <input type="number" name="marks" value="<?php echo $marks ?>"/></br>
              </div>
              <div class="question">
                  <textarea id="name" type="text" name="text"><?php echo $text ?></textarea>
              </div>
              <div class="question">
                  <input type="radio" name="answer" value="1" <?php if($answer == 1) echo 'checked'?>/>
                  <label>A-</label>
                  <input type="text" name="option1" value="<?php echo $option1 ?>" /></br>
              </div>
              <div class="question">
                  <input type="radio" name="answer" value="2" <?php if($answer == 2) echo 'checked'?>/>
                  <label>B-</label>
                  <input type="text" name="option2" value="<?php echo $option2 ?>" /></br>
              </div>
              <div class="question">
                  <input type="radio" name="answer" value="3" <?php if($answer == 3) echo 'checked'?>/>
                  <label>C-</label>
                  <input type="text" name="option3" value="<?php echo $option3 ?>" /></br>
              </div>
              <div class="question">
                  <input type="radio" name="answer" value="4" <?php if($answer == 4) echo 'checked'?>/>
                  <label>D-</label>
                  <input type="text" name="option4" value="<?php echo $option4 ?>" /></br>
              </div>
        </form>


       </div>
        <div id="sidebar">
          <i class="fa fa-trash" onclick="hideSideBar()"></i> 
          <h3>Tips</h3>
          <li>Questions are to be solved, they say!</li>
          <li>at least two options should be provided</li>
          
        </div>
      </div>  
      
      <?php include("../footer.php")?>

    </div>
    

    
    
    
    </body></html>