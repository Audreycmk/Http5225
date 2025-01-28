<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge 1</title>
</head>
<body>

<h1> Quirky Zoo Management System</h1>

<?php
$hour = date('G');
$hour = ceil(rand(1,24));
echo '<h3>The time is now: ' . $hour . '</h3>';

if($hour >= 5 && $hour <=9 ){
    echo 'Bananas, Apples, and Oats';
}
elseif($hour >= 12 && $hour <= 14){
    echo 'Fish, Chicken, and Vegetables';
}
elseif($hour >= 19 && $hour <= 21) {
    echo 'Steak, Carrots, and Broccoli';
} else {
    echo 'No feeding time';
}
?>
</body>
</html>