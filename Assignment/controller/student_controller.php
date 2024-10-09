<?php
require_once "../models/database.php";
require_once "../models/user.php";
session_start();
//connect to db
$database = new Database();
$db = $database->getConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (checkValid(["password", "email", "mobile"])) {
        $password = $_POST["password"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];

        $user = new User($db);
        $user->username = $_SESSION["username"];
        // If user does not input password, get that information from database instead of user input
        $user->password = $password === "" ? $user->getInfo("password", $_SESSION["username"])["password"] : $password;
        // Because you cannot change the fullname  of user, so get that information from database instead of user input
        $user->fullname = $user->getInfo("fullname", $_SESSION["username"])["fullname"];

        // Same as password
        $user->email = $email === "" ? $user->getInfo("email", $_SESSION["username"])["email"] : $email;
        $user->mobile = $mobile === "" ? $user->getInfo("mobile", $_SESSION["username"])["mobile"] : $mobile;
        
        // Cannot update becase of duplicate information
        if ($user->checkExist("email", $email) || $user->checkExist("mobile", $mobile)) {
            echo "Update failed due to duplicate information";
        } else {
            if ($user->update()) {
                echo "Update user successful";
            } else {
                echo "Update failed due to server error";
            }
        }
        
        
    }
}            

// Just function check isset and empty of an information
function checkValid($array) {
    foreach ($array as $key) {
        if (isset($_POST[$key]) && !empty($_POST[$key])) {
            return true;
        } 
    }
}

