<?php 
    if (isset($_FILES["UploadedFile"] , $_POST["submit"])) {
        $target_path = "uploads2/". $_FILES["UploadedFile"]["name"];
        $err = $_FILES["UploadedFile"]["error"];
        if ($err) {
            echo "<script>alert(\"Something went wrong!\")</script>";
        } else if (!exif_imagetype($_FILES["UploadedFile"]["tmp_name"])) {
            echo "<script>alert(\"Don't try to fool me, we only accept image file!\")</script>";
        } else {
            move_uploaded_file($_FILES["UploadedFile"]["tmp_name"], $target_path);
            echo "The file <a href=\"$target_path\">$target_path</a> has been uploaded";
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
        <h1>For some security reason, we only accept image file.</h1>
        <input type="file" name="UploadedFile">
        <input type="submit" name="submit" value="Upload File">
    </form>
</body>
</html>