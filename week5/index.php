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
    $query = "SELECT * FROM colors";
    $colors = mysqli_query($connect, $query);
    echo '<div style="background-color:' . $colors['Hex']. '"></div>'
   
  ?>
</body>
</html>
<!-- test if mysqli is working -->
<!-- echo '<pre>' . print_r($colors) . '</pre>' -->