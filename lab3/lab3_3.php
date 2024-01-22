<?php 
    //connect to db
    $servername = "localhost";
    $database = "credentials";
    $username = "perrito";
    $password = "Vandau2004@";

    // Create connection

    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection

    if (!$conn) {

        die("Connection failed: " . mysqli_connect_error());

    }

    if (isset($_POST["username"], $_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        if (strlen(trim($username)) > 0 && strlen(trim($password)) > 0) {
            $query = "SELECT * FROM credentials.users WHERE username=\"$username\" and password=\"$password\"";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $mess =  "Login succesfully!<br>";
                if (isset($_POST['remember'])) {
                    setcookie("user" , $username , time() + 86400 * 7);
                    $messCookie = "Your login session has been remembered for 7 days!<br>";
                }
            } else {
                $mess = "Username or password wrongs!";
            }
        } else {
            $mess = "Don't try to fool me, you need to enter something!";
        }

        
    }
    mysqli_close($conn);
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            width: 400px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.3;
            z-index: -1;
        }

        form {
            padding: 30px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            margin: 20px 0 0 0;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        button {
            width: 50%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            cursor: pointer;
            margin: 15px;
            transform: translate(-30%, 110%);
        }

        button:hover {
            background-color: #444;
        }
        
    </style>
</head>
<body>
   
    <div class="container">
        <h1>Login</h1>
        <form action="" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <input type="checkbox" id="remember" name="remember">Remember me</input>
            
            <button type="submit">Login</button>
            
        </form>

        <?php 
            if (isset($mess)) {
                echo $mess;
            }
            if (isset($messCookie)) {
                echo $messCookie;
                echo "<br>".$_COOKIE["user"];
            }
            
        ?>

    </div>

    


    </body>
</html>