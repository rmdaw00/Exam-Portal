<?php
session_start();
$errEmail= $email = $password = $name = $errPassword = $errVerPassword = $errName  = "";

function validate(String $type,String $value) {
    switch ($type) {
        case "email": 
            return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value)) ? "" : "invalid Email";
        
        case "password": 
            return (preg_match("/(?=.*[\d])(?=.*[[:upper:]])(?=.*[[:lower:]])(?=.*[-_])/", $value)) ? "" : "invalid password format";

        case "verPassword": 
            return ($value == $_POST['password']) ? "" : "Passwords Dont Match";

        case "name": 
            return (!empty($value)) ? "" : "Required";

        }
        
    
}

if (isset($_POST['email'])) {
    
    $errEmail = validate("email", $_POST['email']);
    $errPassword = validate("password", $_POST['password']);
    $errVerPassword = validate("verPassword", $_POST['verPassword']);
    $errName = validate("name", $_POST['name']);


    $combinedError = $errEmail. $errPassword . $errVerPassword . $errName;

    if ($combinedError == "") {
        //Register
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
    
        $dns = "mysql:host=localhost;dbname=ExamApp";
        $db = new PDO($dns, 'root', '');
        
        
        $hash = sha1($_POST['email'].$_POST['password']);
        $statement = "insert into Users(email, password, name) values('" .$email ."','" . $hash . "','" . $name . "')";
        $resRows = $db->exec($statement);
        
        
        if ($resRows >= 1) {
            include('Registered.php');
            exit();
        ;} 
        
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
    <title>Registration</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body  style="scroll-behavior: auto !important;">
    <?php include("header.php")?>

     <div id="main">
    
        <h1>Register for an Account</h1>

 
        <form action="Register.php" method="POST">

                <div class="question">
                    <label for="email">E-Mail:</label>
                    <input id="email" name="email" type="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']?>"/>
                    <span class="error" id="errEmail"><?php echo $errEmail?></span>
                </div>
                <div class="question">
                    <label for="password">Password:</label>
                    <input id="password" name="password" type="password" />
                    <span class="error" id="errPassword"><?php echo $errPassword?></span>
                </div>
                <div class="question">
                    <label for="verPassword">Verify Password:</label>
                    <input id="verPassword" name="verPassword" type="password"/>
                    <span class="error" id="errVerPassword"><?php echo $errVerPassword?></span>
                </div>

                <div class="question">
                    <label for="name">Name:</label>
                    <input id="name" name="name" type="text" value="<?php if (isset($_POST['name'])) echo $_POST['name']?>"/>
                    <span class="error" id="errName"><?php echo $errName?></span>
                </div>
   
                <input type="submit" value="Register" />
             
              
          </form>
        </div>
        <div id="sidebar">
            <i class="fa fa-trash" onclick="hideSideBar()"></i> 
          <h3>Tips</h3>
          <li>You Register as student, get promoted as teacher</li>
          <li>Passwords must have one each of upper, lower, digit and (-_)</li>
          
        </div>
      </div>  
      
      <?php include("footer.php")?>



</body>
</html>