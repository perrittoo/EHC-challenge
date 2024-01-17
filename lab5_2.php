<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World</title>
</head>
<body>
    <form action="" method="POST">
        <input type="date" id="birth" name="birth">
        <input type="submit">
    </form>
    <?php 
        function checkLeapYear($year) {
            return (($year % 400 == 0) || ($year % 4 == 0 && $year % 100 != 0));              
        }

        $day_of_month = array(31, 28, 31, 30 , 31, 30, 31, 31, 30 , 31 , 30, 31);

        echo "<h1>".date('l jS \of F Y h:i:s A')."</h1>";
        if (isset($_POST['birth'])) {
            $birth = explode("-" ,$_POST['birth']);
            $birth_day = (int)$birth[2]; $birth_month = (int)$birth[1];
            $curr_day = date("j"); $curr_month = date("n"); $curr_year = date("Y");
            // $curr_day = 14; $curr_month = 5; $curr_year = 2023;
            // Check whether the entered birthday is in the future or not
            $res = 0;
            // if ($birth[0] > $curr_year || ($birth[0] == $curr_year && $birth[1] > $curr_month) || (($birth[0] == $curr_year && $birth[1] == $curr_month) && $birth[2] > $curr_day)) {
            //     echo "<h1>Your birth day is not valid.</h1>";
            // } else {
                if ($curr_month < $birth_month) {
                    for ($i = $curr_month + 1; $i < $birth_month; $i++) {
                        $res += $day_of_month[$i - 1];
                    }
                    $res += $day_of_month[$curr_month - 1] - $curr_day + $birth_day + 1;
                } else if ($curr_month > $birth_month) {
                    $day_of_month[1] = (($curr_month <= 2 && $curr_day < 29 && checkLeapYear($curr_year)) || ($birth_month >= 2 && checkLeapYear($curr_year + 1))) ? 29 : 28;
                    $temp = 0;
                    for ($i = $birth_month + 1; $i < $curr_month; $i++) {
                        $temp += $day_of_month[$i - 1];
                    }
                    $temp += $day_of_month[$birth_month - 1] - $birth_day + $curr_day + 1;
                    $res = 365 - $temp + 1;
                } else {
                    $res = (($curr_month <= 2 && checkLeapYear($curr_year)) || checkLeapYear($curr_year + 1)) ? (365 - abs($birth_day - $curr_day) + 1) : (365 - abs($birth_day - $curr_day));
                }
                echo "<h1>Sinh nhật của bạn là ".$birth_day."/".$birth_month."</h1>";
                echo "<h1> Còn ".$res." ngày nữa là đến sinh nhật của bạn ^^</h1>";
            // }
        }
            
    ?>
</body>
</html>