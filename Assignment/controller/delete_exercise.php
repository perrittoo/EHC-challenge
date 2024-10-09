<?php 
    require_once "../models/database.php";
    require_once "../models/user.php";
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);

            // role teacher can delete exercise, role student can delete submission
            if ($_SESSION["role"] == "teacher") {
                $user->delete_exercise($id, $_SESSION["username"]);
                header("Location: ../views/upload_exercise.php");
            } else {
                $user->delete_submission($user->get_submission_by_assignment_id($id), $_SESSION["username"]);
                header("Location: ../views/upload_exercise.php");
            }
        } else {
            echo "<script>alert(\"Something went wrong!\")</script>";
        }
    }
