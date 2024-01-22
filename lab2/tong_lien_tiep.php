<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính Tổng Liên Tiếp</title>
</head>
<body>
    <form action="<?php $_PHP_SELF ?>" method="GET">
        Enter n<input type="text" name="a" />
        <input type="submit" placeholder="Calculate" />

    </form>

    <?php 
        
        if (isset($_GET["a"])) {
            $a = $_GET["a"];
            if (is_numeric($a)) {
                if ($a < 0) {
                    echo "Only positive integer!";
                } else {
                    $sum = 0;
                    for ($i = 1; $i <= $a; $i++) {
                        $sum += $i;
                    }
                    echo "Sum = ".$sum;
                }
                
            } else {
                echo "Invalid input, please try again!";
            }
            
        } 
    ?>
</body>
</html>