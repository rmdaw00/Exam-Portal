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

if (!isset($_GET['qid'])||!isset($_GET['id'])) throw new Exception('Id not supplied');
if (empty($_GET['qid'])||empty($_GET['id'])) throw new Exception('Id not supplied');

$dns = "mysql:host=localhost;dbname=ExamApp";

$db = new PDO($dns, 'root', '');



$resRows = $db->exec("DELETE FROM Question WHERE QuestionID = " . $_GET['qid']);


if ($resRows >= 1) {
    header("Location: ../details.php?id=".$_GET['id']); exit();
} else {
    $error="Something failed";
}
 
}
catch (Exception $e) {
    $error = $e->getMessage();
}

header("Location: ../details.php?id=".$_GET['id'].'&error='  . $error); exit();
?>
