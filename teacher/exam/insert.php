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

if (!isset($_POST['title']) || !isset($_POST['duration']) || !isset($_POST['date'])) throw new Exception('Failed to add, Form filled incorrectly');
if (empty($_POST['title']) || empty($_POST['date']) || empty($_POST['duration'])) throw new Exception('Failed to add, Form filled incorrectly');

$dns = "mysql:host=localhost;dbname=ExamApp";

$db = new PDO($dns, 'root', '');

// $mysqltime = date ('Y-m-d H:i:s', $_GET['date']); 


$resRows = $db->exec('insert into Quiz(title, teacherID, date,duration) values("' .$_POST['title'] . '",' . $_SESSION['userID'] . ',"' . $_POST['date'] . '",' . $_POST['duration'] . ')');


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
