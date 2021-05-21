<?php
 session_start();
try{

if (!isset($_SESSION['userType'])) {
    $error = 'Forbidden Access, Login Please';
    header("Location: ../../../home.php?error=" . $error); exit();
} else {
    if ($_SESSION['userType'] != 'teacher') 
        {
            $error = 'Forbidden Access, you have been reported to the national authorities!';
            header("Location: ../../../home.php?error=" . $error); exit();
        }
}

if (!isset($_POST['qid']) || !isset($_POST['id']) || !isset($_POST['text']) || !isset($_POST['answer']) || !isset($_POST['option1']) ||!isset($_POST['option2'])) throw new Exception('Failed to add, Form filled incorrectly');
if (empty($_POST['qid']) || empty($_POST['id']) ||empty($_POST['text']) ||empty($_POST['answer']) ||empty($_POST['option1']) || empty($_POST['option2'])) throw new Exception('Failed to add, Form filled incorrectly');

$dns = "mysql:host=localhost;dbname=ExamApp";

$db = new PDO($dns, 'root', '');


$resRows = $db->exec('insert into Question(quizID, marks, text, option1, option2, option3, option4, answer) 
                          values(' .$_POST['id'] . ',' . $_POST['marks'] . ',"' . $_POST['text'] . '","' . $_POST['option1'] 
                          . '","' . $_POST['option2'] . '","' . $_POST['option3'] . '","' . $_POST['option4'] . '", ' . $_POST['answer']. ')');


if ($resRows >= 1) {
    header("Location: ../details.php?id=".$_POST['id']); exit();
} else {
    $error="Something failed";
}
 
}
catch (Exception $e) {
    $error = $e->getMessage();
}
header('Location: ../details.php?id='. $_POST['id'] .'&error=' . $error); exit();
?>
