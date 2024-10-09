<?php
require_once "../models/database.php";
require_once "../models/user.php";
//connect to db
$database = new Database();
$db = $database->getConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["username"], $_POST["password"], $_POST["fullname"], $_POST["email"], $_POST["mobile"], $_POST["role"]) && 
    !empty($_POST["username"]) && 
    !empty($_POST["password"]) && 
    !empty($_POST["fullname"]) && 
    !empty($_POST["email"]) && 
    !empty($_POST["mobile"]) && 
    !empty($_POST["role"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        $role = $_POST["role"] === "teacher" ? 1 : 0;



        $user = new User($db);
        $user->username = $username;
        $user->password = $password;
        $user->fullname = $fullname;
        $user->email = $email;
        $user->mobile = $mobile;
        $user->role = $role;
        
        // user can not register with duplicate username, email, mobile but fullname, and password
        if ($user->checkExist("username", $username) || $user->checkExist("email", $email) || $user->checkExist("mobile", $mobile)) {
            echo "Registration failed due to duplicate information";
        } else {
            if ($user->create()) {
                header("Location: ../views/login.html");
            } else {
                echo "Registration failed due to server error";
            }
        }
        
        
    } else {
        echo "Registration failed due to missing information";
    }
    
    

}