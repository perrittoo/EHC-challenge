<?php
    require_once '../models/user.php';
    require_once '../models/database.php';
    session_start();
    $database = new Database();
    $db = $database->getConnection();
    if (isset($_SESSION["username"])) {
        if ($_SESSION["role"] != "teacher") {
            die("You are not authorized to view this page");
        }
    } else {
        header("Location: login.html");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Challenge</title>
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
        textarea {
            width: 100%;
            height: 150px;
            padding: 12px 20px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            font-size: 16px;
            resize: none;
        }

        .a_tag {
            color: #007BFF; 
            text-decoration: none; 
            font-weight: bold; 
            transition: color 0.3s ease, text-decoration 0.3s ease; 
        }

        .a_tag:hover {
            color: #0056b3; 
            text-decoration: underline;
        }

        
        .a_tag:active {
            color: #003d7a; 
        }

        
        .a_tag:visited {
            color: #551A8B; 
        }

        
        .a_tag:focus {
            outline: none; 
            color: #FF4500; 
            text-decoration: underline; 
        }

    </style>
</head>
<body>
    <header>
        <div class="logo">📒 ChallengePortal</div>
        <nav>
            <a href="../controller/logout.php">Logout</a>
            <a href="teacher.php">Student Management</a>
            <a href="view_user.php">View</a>
        </nav>
    </header>
    
    <form action="../controller/challenge.php" method="POST" enctype="multipart/form-data">
        <label for="title">Challenge title:</label>
        <input type="text" id="title" name="title" required>

        <label for="hint">Challenge hint:</label>
        <textarea type="text" id="hint" name="hint" required></textarea>
    
        <label for="challenge_file">Upload File:</label>
        <input type="file" id="challenge_file" name="challenge_file" required>

        <button type="submit" name="submit_challenge">Create Challenge</button>
    </form>
    <?php 
        $user = new User($db);
        $challenges = $user->get_challenge($_SESSION["username"]);
        if ($challenges) 
            foreach ($challenges as $challenge): ?>
                    <h1> <?php echo $challenge['title']; ?></h1>
                    <p> <?php echo nl2br($challenge['hint']); ?></p>
                    <a class="a_tag" href='../static/teacher/challenge/<?php echo $challenge['file_path']; ?>'>Download the challenge file.</a><br>
                    <a class="a_tag" href="../controller/delete_challenge.php?id=<?php echo $challenge['id']; ?>">Delete</a>
                <?php endforeach; ?>
                    
</body>
</html>