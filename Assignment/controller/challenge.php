<?php
require_once "../models/database.php";
require_once "../models/user.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit_challenge']) && !empty($_POST['hint']) && !empty($_FILES['challenge_file']) && !empty($_POST["title"]) && $_SESSION["role"] == "teacher") {
        $fileName = $_FILES["challenge_file"]["name"];
        $title = $_POST['title'];
        $hint = $_POST['hint'];

        $err = $_FILES["assignment_file"]["error"];
        
        // match regex for file name that only contains characters and spaces and ends with .txt
        if ($err || !preg_match("/^[a-zA-Z\s]+\.txt$/", $fileName)) {
            echo "<script>alert(\"Something went wrong!\")</script>";
        } else {
            $target_path = '../static/uploads/teacher/challenge/'. $fileName;
            move_uploaded_file($_FILES['challenge_file']['tmp_name'], $target_path);
            // move file to /teacher/challenge folder then insert data to the database
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);
            $user->upload_challenge($title, $_SESSION["username"], $hint, $fileName);
            
            
            header("Location: ../views/create_challenge.php");
        }
    } else {
        echo "<script>alert(\"Something went wrong!\")</script>";
    }
}