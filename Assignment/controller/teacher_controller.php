<?php
require_once "../models/database.php";
require_once "../models/user.php";
//connect to db
$database = new Database();
$db = $database->getConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (checkValid(["action"])) {
        $action = $_POST["action"];
        switch ($action) {
            // In case of add and update, the information of user is the same (username, password, ...) so i use the same code
            case "add": case "update": {
                if (checkValid(["username", "password", "fullname", "email", "mobile"])) {
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    $fullname = $_POST["fullname"];
                    $email = $_POST["email"];
                    $mobile = $_POST["mobile"];

                    $user = new User($db);
                    $user->username = $username;
                    $user->password = $password === "" ? $user->getInfo("password", $username)["password"] : $password;
                    $user->fullname = $fullname === "" ? $user->getInfo("fullname", $username)["fullname"] : $fullname;
                    $user->email = $email === "" ? $user->getInfo("email", $username)["email"] : $email;
                    $user->mobile = $mobile === "" ? $user->getInfo("mobile", $username)["mobile"] : $mobile;

                    if ($action === "add") {
                        if ($user->checkExist("username", $username) || $user->checkExist("email", $email) || $user->checkExist("mobile", $mobile)) {
                            echo "Registration failed due to duplicate information";
                        } else {
                            if ($user->create()) {
                                echo "Add user successful";
                            }
                        }
                    } else {
                        if ($user->checkExist("email", $email) || $user->checkExist("mobile", $mobile)) {
                            echo "Update failed due to duplicate information";
                        } else {
                            if ($user->update()) {
                                echo "Update user successful";
                            }
                        }
                    }
                    
                } else {
                    echo "Add or update failed due to missing information";
                }
                break;
            }
            case "delete": {
                if (checkValid(["delete-student"])) {
                    $username = $_POST["delete-student"];
                    $user = new User($db);
                    $user->username = $username;
                    if ($user->delete()) {
                        echo "Delete user successful";
                    } 
                } else {
                    echo "Delete failed due to missing information";
                }
                break;
            }
        }
    } else {
        echo "Missing action";
    }

}

function checkValid($array) {
    foreach ($array as $key) {
        if (isset($_POST[$key]) && !empty($_POST[$key])) {
            return true;
        } 
    }
}
