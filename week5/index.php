<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <?php
    //connection string ('localhost', 'username', 'pw', 'DB name')
    $connect = mysqli_connect('localhost', 'root', 'root', 'color');

    if(!$connect){
      die('Connection Failed: ' . mysqli_connect_error());
    }
    
     //table name
     $query = "SELECT `Name`, `Hex` FROM colors";
     $colors = mysqli_query($connect, $query);
 
     if(mysqli_num_rows($colors) > 0){
       while($row = mysqli_fetch_assoc($colors)){
           echo '<div style="
                   width:180px; 
                   padding:10px; 
                   margin:10px; 
                   display:inline-block; 
                   text-align:center; 
                   font-family:Arial; 
                   font-weight:bold; 
                   color:#fff; 
                   border-radius:8px; 
                   box-shadow:2px 2px 5px rgba(0,0,0,0.2); 
                   background-color:' . htmlspecialchars($row['Hex']) . ';">
                 <h2>' . htmlspecialchars($row['Name']) . '</h2>
                 </div>';
     }
   }
   ?>
</body>
</html>
<!-- test if mysqli is working -->
<!-- echo '<pre>' . print_r($colors) . '</pre>' -->

