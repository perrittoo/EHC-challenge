<?php
require_once "../models/database.php";
require_once "../models/user.php";
//connect to db
$database = new Database();
$db = $database->getConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];
    switch ($action) {
        case "add":
            addStudent($db);
            break;
        case "delete":
            deleteStudent($db);
            break;
        case "update":
            updateStudent($db);
            break;
        default:
            echo "Invalid action";
    }
    
}

function updateStudent($db) {
    if (isset($_POST["id"], $_POST["name"] , $_POST["mobile"], $_POST["email"]) && 
    !empty($_POST["id"]) && 
    !empty($_POST["name"]) && 
    !empty($_POST["mobile"]) && 
    !empty($_POST["email"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $mobile = $_POST["mobile"];
        $email = $_POST["email"];

        $user = new User($db);
        $user->id = $id;
        $user->name = $name;
        $user->mobile = $mobile;
        $user->email = $email;
        
        if ($user->checkExist("id", $id)) {
            if (!$user->checkExist("email", $email) && !$user->checkExist("mobile", $mobile)) {
                if ($user->update()) {
                    echo "Update student successfully.";
                } else {
                    echo "Unable to update student.";
                }
            } else {
                echo "Email or mobile already exists.";
            }
        } else {
            echo "Student is not existed.";
        }
        
    } else {
        die("Don't try to fool me, you need to enter something!");
    }
}

function addStudent($db) {
    if (isset($_POST["id"], $_POST["name"] , $_POST["mobile"], $_POST["email"]) && 
    !empty($_POST["id"]) && 
    !empty($_POST["name"]) && 
    !empty($_POST["mobile"]) && 
    !empty($_POST["email"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $mobile = $_POST["mobile"];
        $email = $_POST["email"];

        $user = new User($db);
        $user->id = $id;
        $user->name = $name;
        $user->mobile = $mobile;
        $user->email = $email;
        
        if ($user->checkExist("id", $id)) {
            echo "Student already exists.";
        } else if ($user->checkExist("email", $email)) {
            echo "Email already exists.";
        } else if ($user->checkExist("mobile", $mobile)) {
            echo "Mobile already exists.";
        } else {
            if ($user->create()) {
                echo "Create student successfully.";
            } else {
                echo "Unable to create student.";
            }
        }
        
        
    } else {
        die("Don't try to fool me, you need to enter something!");
    }
}

function deleteStudent($db) {
    if (isset($_POST["id"]) && 
    !empty($_POST["id"]))  {
        $id = $_POST["id"];

        $user = new User($db);
        $user->id = $id;
        
        if ($user->checkExist("id", $id)) {
            if ($user->delete()) {
                echo "Delete student successfully.";
            } else {
                echo "Unable to create student.";
            }
        } else {
            echo "Student is not existed.";
            return;
        }
        
        
        
    } else {
        die("Don't try to fool me, you need to enter something!");
    }

}