<?php 
    require_once "../models/database.php";
    require_once "../models/user.php";
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['upload_exercise'], $_POST['id']) && !empty($_POST['id']) && !empty($_FILES['submission_file'])) {
            $fileName = $_FILES["submission_file"]["name"];
            $id = $_POST['id'];

            $err = $_FILES["submission_file"]["error"];

            $fileExtension = strtolower(pathinfo($fileName , PATHINFO_EXTENSION));
            
            $allowedExtensions = array('txt', 'pdf', 'doc', 'docx');
            if ($err || !in_array($fileExtension, $allowedExtensions)) {
                echo "<script>alert(\"Something went wrong!\")</script>";
            } else {
                $newFileName = md5($fileName . '_' . time()) . '.' . $fileExtension;
                $target_path = '../static/uploads/student/'. $newFileName;
                move_uploaded_file($_FILES['submission_file']['tmp_name'], $target_path);
                $database = new Database();
                $db = $database->getConnection();
                $user = new User($db);
                
                $id = $_POST['id'];
                $user->submissions($id, $_SESSION["username"], $newFileName);
                
                
                header("Location: ../views/upload_exercise.php");
            }
        } else {
            echo "<script>alert(\"Something went wrong!\")</script>";
        }
    }
    
?>