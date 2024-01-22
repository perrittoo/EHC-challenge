<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Calculator</title>
</head>
<body>
    <form action="<?php $_PHP_SELF ?>" method="POST">
        a<input type="text" name="a" required /><br>
        b<input type="text" name="b"  required /><br>
        <input type="submit" placeholder="Calculator"/>


    </form>

    <?php
        if (isset($_POST["a"] , $_POST["b"])) {
            if (is_numeric($_POST["a"]) && is_numeric($_POST["b"])) {
                $a = $_POST["a"];
                $b = $_POST["b"];
                if ($b == 0) {
                    echo "Can't divied by zero!";
                } else {
                    echo "Addition: ".($a + $b)."<br>";
                    echo "Substraction: ".($a - $b)."<br>";
                    echo "Multiplication: ".($a * $b)."<br>";
                    echo "Division: ".($a / $b)."<br>";
                }
            } else {
                echo "Invalid input, please try again.";
            }
            
            
        } 
        
    ?>
</body>
</html>