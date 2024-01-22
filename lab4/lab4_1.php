<?php 
    if (isset($_POST["submit"]) && isset($_FILES["UploadedFile"])) {
        if ($_FILES["UploadedFile"]["error"] > 0)
            echo "Something went wrong!";
        else {
            $target_path = "uploads1/" .$_FILES["UploadedFile"]["name"];
            move_uploaded_file($_FILES["UploadedFile"]["tmp_name"], $target_path);
            echo "Upload sucessfully<br/>";
            echo "The file <a href=\"$target_path\">$target_path</a> has been uploaded<br>";
            echo "File type: " . $_FILES["UploadedFile"]["type"] . "<br>";
            echo "Size: " . ((int)$_FILES["UploadedFile"]["size"] / 1024) . "KB";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <h1>Upload an image</h1>
        <input type="file" name="UploadedFile">
        <input type="submit" name="submit" value="Upload File">
    </form>
</body>
</html>