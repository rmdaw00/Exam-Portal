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

if (!isset($_POST['id']) || !isset($_POST['title']) || !isset($_POST['date'])|| !isset($_POST['duration'])) throw new Exception('Failed to add, Form filled incorrectly');
if (!isset($_POST['id']) || empty($_POST['title']) || empty($_POST['date'])|| empty($_POST['duration'])) throw new Exception('Failed to add, Form filled incorrectly');

$dns = "mysql:host=localhost;dbname=ExamApp";

$db = new PDO($dns, 'root', '');



$resRows = $db->exec('UPDATE Quiz SET title="' . $_POST['title'] . '",date="' . $_POST['date'] . '",duration=' . $_POST['duration'] . ' WHERE QuizID = ' . $_POST['id']);


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
