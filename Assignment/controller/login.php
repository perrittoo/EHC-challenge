<?php
require_once "../models/database.php";
require_once "../models/user.php";
session_start();
//connect to db
$database = new Database();
$db = $database->getConnection();
$table_name = "ethicalhackerclub.users";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"], $_POST["password"]) && 
    !empty($_POST["username"]) && 
    !empty($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = new User($db);
        $user->username = $username;
        $user->password = $password;
        
        if ($user->login()) {
            $_SESSION["username"] = $username;
            $role = $user->getRole($username) === 1 ? "teacher" : "student";
            $_SESSION["role"] = $role;
            if ($role === "teacher") {
                header("Location: ../views/teacher.php");
            } else {
                header("Location: ../views/student.php");
            }
        } else {
            echo "Login failed due to server error";
        }
        
        
    } else {
        echo "Login failed due to missing information";
    }
    
}

