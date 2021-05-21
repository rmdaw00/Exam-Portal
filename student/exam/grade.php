<?php session_start();
if (!isset($_SESSION['userName'])) {
    //Not Logged
    header("Location: ../../home.php");
    die();
} else {
  If ($_SESSION['userType'] == 'teacher') {
    //IS Teacher
    header("Location: ../../teacher/home.php");
    die();

  } else {
    //IS STUDENT

    $dns = "mysql:host=localhost;dbname=ExamApp";
    $db = new PDO($dns, 'root', '');

    $userName = $_SESSION['userName'];
    $userID = $_SESSION['userID'];

    try {
      if (!isset($_POST['id'])) throw new Exception("Exam ID not Supplied");
      if (empty($_POST['id'])) throw new Exception("Exam ID not Supplied");
      $id = $_POST['id'];
      $returnSelect = $db->query('SELECT * FROM Quiz Join Mark ON Mark.quizID = Quiz.QuizID WHERE Mark.userID = '. $_SESSION['userID'] . ' AND Quiz.QuizID = ' . $id);
      
      while($rowArray = $returnSelect->fetch())
      {
        
         if (!empty($rowArray['dateTaken'])) throw new Exception("Exam Already Attempted");
      }


      $returnSelect = $db->query('SELECT Quiz.QuizID, Quiz.date, Quiz.title, Quiz.duration, 
      Question.QuestionID, Question.marks, Question.text, Question.option1, 
      Question.option2, Question.option3, Question.option4, Question.Answer, 
      sum(Question.marks) AS total, count(Question.marks) AS count FROM `Quiz` 
                  Join Question ON Question.quizID = Quiz.QuizID 
          Group by Quiz.QuizID
          Having Quiz.QuizID = '. $id);
        while($rowArray = $returnSelect->fetch())
        {
            //these dont change
            $title = $rowArray['title'];
            $duration = $rowArray['duration'];
            $totalMarks = $rowArray['total'];
            $date = $rowArray['date'];
            $count = $rowArray['count'];
        
        
        }
      ?>
      

      <!DOCTYPE html>
        <html ml-update="aware">
        <head>
            <link rel="stylesheet" href="../../style.css"/>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
            <script src="../../scripts.js"></script>
            <title>Quiz Portal</title>
        </head>
        <body  style="scroll-behavior: auto !important;">
        <?php include("../../header.php");?>

        <?php include("../../shared/questionfx.php")?>
                

        <div id="main">
              <h1>Quiz</h1>
              <form id="examForm">
              <?php

                    $returnSelect = $db->query('SELECT Quiz.QuizID, Quiz.date, Quiz.title, Quiz.duration, 
                                                Question.QuestionID, Question.marks, Question.text, Question.option1, 
                                                Question.option2, Question.option3, Question.option4, Question.Answer, 
                                                sum(Second.marks) AS total, count(Second.marks) AS count FROM `Quiz` 
                                                            Join Question ON Question.quizID = Quiz.QuizID 
                                                            Join Question AS Second ON Question.quizID = Quiz.QuizID 
                                                    Group by Question.QuestionID
                                                    Having Quiz.QuizID = '. $id);
                    $Qcounter = 0;
                    $correctQ = 0;
                    $correctMark= 0;
                    
                    
                    while($rowArray = $returnSelect->fetch())
                    {

                        
                        if ($Qcounter != 0) echo '<hr>';
                        echo 'Question ' . $Qcounter++ . ') ' .questionToHTML($rowArray['QuestionID'],$rowArray['marks'],$rowArray['text'],$rowArray['option1'],
                                                    $rowArray['option2'],$rowArray['option3'],$rowArray['option4'],$rowArray['Answer']) ;

                        //Counting Correct Answers
                        if ($_POST['a'.$rowArray['QuestionID']]==$rowArray['Answer']) {
                            $correctQ++;
                            $correctMark+=$rowArray['marks'];
                        }
                    }

                    $resRows = $db->exec('insert into Mark(userID, quizID, mark, maxMark) values(' .$_SESSION['userID'] . ',' . $_POST['id'] . ',' . $correctMark . ',' . $totalMarks . ')');
                    $markPerc = number_format($correctMark/$totalMarks*100,2) 
                    ?>
              </form>
              <form id="PostExam">
                  <button class="formButton" type="button" onclick="reviewQuiz()">Start</button>
                  <div class="quizDetails">
                      <div><strong>Title:</strong> <?php echo$title?></div>
                      <div><strong>Date:</strong> <?php echo $date?></div>
                      <div><strong>Questions:</strong> <?php echo   $correctQ .'/'.$count ?></div>
                      <div><strong>Marks:</strong> <?php echo $correctMark . '/' .$totalMarks?></div>

                        <?php if ($markPerc >= 50) { ?> 
                            <div style="color:green;"><strong>Percentage: <?php echo '%'. $markPerc ?></strong> </div>
                            <div style="color:green;"><strong>Congrats you passed!</strong></div>
                        <?php } else {?>
                            <div style="color:red;"><strong>Percentage: <?php echo '%'. $markPerc ?></strong> </div>
                            <div style="color:red;"><strong>You Failed!</strong><br>now go cry to your mama</div>
                        <?php } ?>
                  </div>
              </form>



          </div>
            <div id="sidebar">
                <h3>Tips</h3>
                <li>Nevermind if you lost, This site is about success, if you fail, it is your problem!</li>
              
            </div>
          </div>  
          
          <?php include("../../footer.php")?>

        </div>
        

        
        
        
        </body></html>

    <?php
    } catch (Exception $e) {
      header("Location: ../home.php?error=" . $e->getMessage());
    }
    
  }
}
  
?>

