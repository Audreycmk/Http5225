<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge 2</title>
</head>
<body>
    <h1>The Magic Number Game</h1>

    <h3>The magic number is:</h3>
    <?php
    $randomNumber = ceil(rand(1,100));
    echo $randomNumber;
    ?>
    <br>
    <?php
    if ($randomNumber%3 == 0 && $randomNumber%5 == 0) {
    echo "FizzBuzz";
    }
    elseif ($randomNumber%3 == 0 ) {
        echo "Fizz";
        }
    elseif ($randomNumber%5 == 0 ) {
        echo "Buzz";
        }
    else{
        echo $randomNumber;
        }
    ?>
</body>
</html>