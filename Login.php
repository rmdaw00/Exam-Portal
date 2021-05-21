<?php 
    session_start();
    $error = '';
    If (isset($_POST['email']) && isset($_POST['email'])){
        try {
            $email = $password = '';
            if (empty($_POST['email'])) 
                throw new Exception("empty Email");
             else 
                $email = $_POST['email'];
            if (empty($_POST['password'])) 
                throw new Exception("empty password");
             else 
                $password = $_POST['password'];
            
                $dns = "mysql:host=localhost;dbname=ExamApp";
                $db = new PDO($dns, 'root', '');
                
                
                $hash = sha1($email.$password);
                $returnSelect = $db->query("SELECT * FROM Users WHERE email = '" . $email. "' AND password = '" . $hash ."'");
                
                $error = "No User/Password matching";
                while($rowArray = $returnSelect->fetch())
                {
                    $error = '';
                    $_SESSION['userName'] = $rowArray['name'];
                    $_SESSION['userType'] = $rowArray['isTeacher']?'teacher':'student';
                    $_SESSION['userID'] = $rowArray['id'];
                    
                    if ($rowArray['isTeacher']) {
                        header("Location: ./teacher/home.php");
                        die();
                    } else {
                        header("Location: ./student/home.php");
                        die();
                    }
                }
                
                

                
        } catch(Exception $e){

            $error = $e->getMessage();
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['password'] = $_POST['password'];
        }
    } 
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="scripts.js"></script>
    <link rel="stylesheet" href="style.css" />
    <title>Quiz Portal</title>
    </head>
    <body  style="scroll-behavior: auto !important;">
    <?php include("header.php")?>
    
     <div id="main">
            
          <h1>Login </h1>
          <form action="Login.php" method="POST">
                <div class="question">
                    <label for="email">E-Mail:</label>
                    <input id="email" name="email" type="email"/>
                </div>
                <div class="question">
                    <label for="password">Password:</label>
                    <input id="password" name="password" type="password"/>
                </div>
    
                <div class="question">
                        <input type="submit" value="Login" /> <?php if (!empty($error)) echo  '<span class="error">' . $error . '</span>' ?>
                    </div>
               
        </form>
       </div>
        <div id="sidebar">
            <i class="fa fa-trash" onclick="hideSideBar()"></i> 
          <h3>Info</h3>
          <li>John is a Student, email is: joh@aa.com</li>
          <li>Mark is a Teacher, email is: mar@aa.com</li>
          <li>both their passwords are 1234</li>
        </div>
      </div>  
      
      <?php include("footer.php")?>

    </div>

    
</body>
</html>