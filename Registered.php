<!DOCTYPE html>
    <html ml-update="aware">
    <head>
        <link rel="stylesheet" href="style.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <title>Quiz Portal</title>
    </head>
    <body  style="scroll-behavior: auto !important;">
    <?php include("header.php")?>

     <div id="main">
          <h1>Registered</h1>
          <p>Welcome Aboard <?php if (isset($name)) echo $name;?>, Please Login!</p>
       </div>
        <div id="sidebar">
          <i class="fa fa-trash" onclick="hideSideBar()"></i> 
          <h3>Tip</h3>
          <li>good people sign in again</li>
         
        </div>
      </div>  
      
      <?php include("footer.php")?>

    </div>
    

    
    
    
    </body></html>