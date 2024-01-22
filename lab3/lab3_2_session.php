<?php 
    $_SESSION['used']=[];
    if (!$_SESSION['used'])
        session_start(); 
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup Form</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        height: 100vh;
    }
    .main-block {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        margin-top: 300px;
      
    }

    form {
        display: flex;
        flex-direction: column;
    }

    input,
    button {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        background-color: #4caf50;
        color: #fff;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    .form-container.left {
        margin-right: 20px;
    }

    .form-container.right {
        margin-left: 20px;
    }
    </style>
</head>
<body>
    <div class="main-block">
        <div class="form-container left">
            <form id="loginForm" method="POST">
                <h2>Login</h2>
                <label for="loginUsername">Username</label>
                <input type="text" id="loginUsername" name="loginUsername">
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="loginPassword" required>
                
                <button type="submit">Login</button>
            </form>
        </div>

        <div class="form-container right">
            <form id="signupForm" method="POST">
                <h2>Sign Up</h2>
                <label for="signupUsername">Username</label>
                <input type="text" id="signupUsername" name="signupUsername" required>
                <label for="signupEmail">Email</label>
                <input type="email" id="signupEmail" name="signupEmail" required>
                <label for="signupPassword">Password</label>
                <input type="password" id="signupPassword" name="signupPassword" required>
                <label>
                    <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
                        I agree to the Terms of Service
                </label>
                <button type="submit">Sign Up</button>
            </form>
        </div>

    </div>
    
    <?php 
      
        if (isset($_POST['loginUsername'], $_POST['loginPassword'])) {
            $username = $_POST['loginUsername'];
            $password = $_POST['loginPassword'];
            if (strlen(trim($username)) > 0 && strlen(trim($password))) {
                $check_user = false;
                for ( $i = 0; $i < count($_SESSION['used']); $i++ ) {
                    $credential = $_SESSION['used'][$i];
                    if ($credential['username'] == $username && $credential['password'] == $password) {
                        $check_user = true;
                    } 
                }
                if ($check_user) {
                    echo "Welcome back my master, ".$credential['username'].'<br>';
                } else {
                    echo "Invalid username or password.<br>";
                }

            } else {
                echo "Don't try to fool me, you need to enter something!<br>";
            }

            
        }

        //sign up
        function checkPassword($password) {
            if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/' , $password)) {
                return true;
            }
        }

        if (isset($_POST["signupUsername"], $_POST["signupPassword"] , $_POST["signupEmail"])) {
            $username = $_POST["signupUsername"];
            $password = $_POST["signupPassword"];
            $email = $_POST["signupEmail"];
            if (strlen(trim($username)) > 0 && strlen(trim($password)) > 0 && strlen(trim($email)) > 0) {
                
                $check_user_exist = false;
                $check_email_exist = false;
                for ( $i = 0; $i < count($_SESSION['used']); $i++ ) {
                    if ($_SESSION['used'][$i]['username'] == $username) {
                        $check_user_exist = true;
                    }
                    if ($_SESSION['used'][$i]['email'] == $email) {
                        $check_email_exist = true;
                    }
                }
                if ($check_user_exist) {
                    echo "This user exists.<br>";
                } else if (!checkPassword($password)) {
                    echo "Password is not strong enough or contains some blacklist characters.<br>";
                } else if ($check_email_exist) {
                    echo "This email exists.<br>";
                } else {
                    array_push($_SESSION['used'] , array('username' => $username, 'password' => $password , 'email' => $email));
                    echo "Create user succesfully!<br>";
                }
            } else {
                echo "Don't try to fool me, you need to enter something!";
            }
        }
        // for ( $i = 0; $i < count($_SESSION['used']); $i++ ) {
        //     echo $_SESSION['used'][$i]['username'].'<br>';
        //     echo $_SESSION['used'][$i]['password'].'<br>';
        // }
    ?>
</body>
</html>
