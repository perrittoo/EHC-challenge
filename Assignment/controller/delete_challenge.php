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

            $user->delete_challenge($id, $_SESSION["username"]);
            header("Location: ../views/create_challenge.php");
            
        } else {
            echo "<script>alert(\"Something went wrong!\")</script>";
        }
    }
