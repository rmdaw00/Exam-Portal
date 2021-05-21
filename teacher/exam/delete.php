<?php
 session_start();
try{

if (!isset($_SESSION['userType'])) {
    $error = 'Forbidden Access, Login Please';
    header("Location: ../../home.php?error=" . $error); exit();
} else {
    if ($_SESSION['userType'] != 'teacher') 
        {
            $error = 'Forbidden Access, you have been reported to the national authorities!';
            header("Location: ../../home.php?error=" . $error); exit();
        }
}

if (!isset($_GET['id'])) throw new Exception('Id not supplied');
if (empty($_GET['id'])) throw new Exception('Id not supplied');

$dns = "mysql:host=localhost;dbname=ExamApp";

$db = new PDO($dns, 'root', '');



$resRows = $db->exec("DELETE FROM Quiz WHERE QuizID = " . $_GET['id'] . " AND teacherID = " . $_SESSION['userID']);


if ($resRows >= 1) {
    header("Location: ../home.php"); exit();
} else {
    $error="Something failed";
}
 
}
catch (Exception $e) {
    $error = $e->getMessage();
}

header("Location: ../home.php?error=" . $error); exit();
?>
