<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <?php 
        $my_array = array('EHC' , 'HackYourLimits' , 'Training');
        $min_len = strlen($my_array[0]);
        $max_len = 0;
        foreach ($my_array as $str) {
            if (strlen($str) > $max_len) {
                $max_len = strlen($str);
            }
            if (strlen($str) < $min_len) {
                $min_len = strlen($str);
            }
        }
        echo "min_length = $min_len<br>";
        echo "max_length = $max_len";
    ?>
</body>
</html>