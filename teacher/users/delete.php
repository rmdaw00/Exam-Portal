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

if (!isset($_GET['id'])) throw new Exception('Failed to get ID');
if (empty($_GET['id'])) throw new Exception('Failed to get ID');

if ($_GET['id'] == 1 || $_GET['id'] == 2) throw new Exception('Essential user, cant be removed');

$dns = "mysql:host=localhost;dbname=ExamApp";

$db = new PDO($dns, 'root', '');



$resRows = $db->exec("DELETE FROM Users WHERE id = " . $_GET['id']);


if ($resRows >= 1) {
    header("Location: ../users.php"); exit();
} else {
    $error="Something failed";
}
 
}
catch (Exception $e) {
    $error = $e->getMessage();
}

header("Location: ../users.php?error=" . $error); exit();
?>
