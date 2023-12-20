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
                <input type="text" id="loginUsername" name="loginUsername" required>
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
        //login 
        if (isset($_POST['loginUsername'], $_POST['loginPassword'])) {
            $username = $_POST['loginUsername'];
            $password = $_POST['loginPassword'];
            $query = "SELECT * from credentials.users WHERE username=\"$username\" and password=\"$password\"";

            $res = mysqli_query($conn, $query);
            if(mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    echo "Welcome back my master, ".$row["username"].'<br>';
                }

            } else {
                echo "Wrong username or password.<br>";
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
            $queryUser = "SELECT * from credentials.users WHERE username=\"$username\"";
            $resUser = mysqli_query($conn, $queryUser);

            $queryEmail = "SELECT * from credentials.users WHERE email=\"$email\"";
            $resEmail = mysqli_query($conn, $queryEmail);

            //troll =))
            $queryPass = "SELECT * from credentials.users WHERE password=\"$password\"";
            $resPass = mysqli_query($conn, $queryPass);

            if (mysqli_num_rows($resUser) > 0) {
                echo "This user exists.<br>";
            } else if (mysqli_num_rows($resPass) > 0) {
                while ($row = mysqli_fetch_array($resPass)) {
                    echo "This password was used by ".$row["username"].'<br>';
                }
            } else if (!checkPassword($password)) {
                echo "Password is not strong enough.<br>";
            } else if (mysqli_num_rows($resEmail) > 0) {
                echo "This email exists.<br>";
            } else {
                $queryId = "SELECT personId FROM credentials.users";
                $resId = mysqli_query($conn, $queryId);
                $id = mysqli_num_rows($resId) + 1;

                $queryUpdate = "INSERT INTO credentials.users (personId , username, password, email) VALUES ($id, '$username' , '$password', '$email');";
                $resUpdate = mysqli_query($conn, $queryUpdate);
                echo "Create user succesfully!<br>";
            }
        }


        mysqli_close($conn);
    ?>
</body>
</html>
