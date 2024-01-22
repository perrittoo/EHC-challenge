<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" id="input" name="input" require>
        <input type="submit">
    </form>

    <?php 
        if (isset($_POST['input'])) {
            $myStr = $_POST['input'];
            if (strlen(trim($myStr)) > 0) {
                $myStr = preg_replace("/[^0-9,.]/" , "" , $myStr);
                echo $myStr;
            } else {
                echo "Please input something!";
            }
        }
    ?>
</body>
</html>