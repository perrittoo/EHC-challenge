<?php 
    require_once "../models/database.php";
    require_once "../models/user.php";
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['upload_exercise']) && !empty($_POST['title']) && !empty($_FILES['assignment_file']) && $_SESSION["role"] == "teacher") {
            $fileName = $_FILES["assignment_file"]["name"];
            $title = $_POST['title'];
            $description = $_POST['description'] ?? '';

            $err = $_FILES["assignment_file"]["error"];

            $fileExtension = strtolower(pathinfo($fileName , PATHINFO_EXTENSION));
            
            $allowedExtensions = array('txt', 'pdf', 'doc', 'docx');
            if ($err || !in_array($fileExtension, $allowedExtensions)) {
                echo "<script>alert(\"Something went wrong!\")</script>";
            } else {
                $newFileName = md5($fileName . '_' . time()) . '.' . $fileExtension;
                $target_path = '../static/uploads/teacher/'. $newFileName;
                move_uploaded_file($_FILES['assignment_file']['tmp_name'], $target_path);
                $database = new Database();
                $db = $database->getConnection();
                $user = new User($db);
                $user->upload_exercise($title, $_SESSION["username"], $description, $newFileName);
                
                
                header("Location: ../views/upload_exercise.php");
            }
        } else {
            echo "<script>alert(\"Something went wrong!\")</script>";
        }
            
        
    }
    