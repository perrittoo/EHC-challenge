<?php
    require_once "../models/user.php";
    require_once "../models/database.php";
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.html");
    }
    $database = new Database();
    $db = $database->getConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solve the Challenge</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* Header styling */
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            font-size: 1em;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* Form styling */
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        form label {
            font-size: 1.1em;
            margin-bottom: 10px;
            display: block;
        }

        form select, form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        form button:hover {
            background-color: #45a049;
        }

        /* Heading and paragraph styling */
        h1 {
            font-size: 2em;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        h3 {
            font-size: 1.5em;
            color: #555;
            margin-bottom: 10px;
            text-align: center;
        }

        p {
            font-size: 1.1em;
            color: #666;
            line-height: 1.6;
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

    </style>
</head>
    <header>
        <div class="logo">📒 ChallengePortal</div>
        <nav>
            <a href="../controller/logout.php">Logout</a>
            <a href="student.php">Student Management</a>
            <a href="view_user.php">View</a>
        </nav>
    </header>
    <form method="POST">
        <label for="challenge_id">Choose Challenge:</label>
        <select id="challenge_id" name="challenge_id" required>
            <?php
                $user = new User($db);
                $challenges = $user->get_challenge();
                if ($challenges) {
                    foreach ($challenges as $challenge) {
                        echo $challenge["id"];
                        echo "<option value='" . $challenge['id']."'>" . $challenge['title'] . " of Teacher " . $challenge["publisher"] . "</option>";
                    }
                }
            ?>
        </select>

        <button type="submit" name="choose_challenge">Submit</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['choose_challenge']) && isset($_POST['challenge_id']) && !empty($_POST['challenge_id'])) {
                $challenges = $user->get_challenge("", $_POST['challenge_id']);
                if ($challenges) {
                    foreach ($challenges as $challenge): ?>
                        <h1> Challenge by Teacher <?php echo $challenge['publisher']; ?></h1>
                        <h3> Title: <?php echo $challenge['title']; ?></h3>
                        <p> Hint: <?php echo nl2br($challenge['hint']); ?></p>
                        <form action="../controller/solve.php" method="POST" id="submitForm">
                            <input type="hidden" name="challenge_id" value="<?php echo $challenge["id"]; ?>" require>
                            <label for="student_answer">Your answer:</label>
                            <input type="text" id="student_answer" name="student_answer" required>

                            <button type="submit" name="submit_answer">Submit</button>
                        </form>
                    <?php endforeach; ?>
                <?php }
            } 
        } 
    ?>
</body>
</html>

