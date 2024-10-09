<?php  
require_once "../models/user.php";
require_once "../models/database.php";
$database = new Database();
$db = $database->getConnection();    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {              
    if (isset($_POST['submit_answer'], $_POST['challenge_id'], $_POST['student_answer']) && 
    !empty($_POST['challenge_id']) && 
    !empty($_POST['student_answer'])) {
        $challengeId = $_POST['challenge_id'];
        $studentAnswer = trim($_POST['student_answer']);
        $user = new User($db);
        $challenge = $user->get_challenge("", $challengeId)[0];
        // get the file name without extension .txt
        $fileName = substr($challenge['file_path'], 0, strpos($challenge['file_path'], "."));
        
        $isCorrect = $studentAnswer === $fileName ? true : false;

        
        if ($isCorrect) {
            $filePath = "../static/uploads/teacher/challenge/" . $challenge['file_path'];
            if (file_exists($filePath)) {
                $poem_content = file_get_contents($filePath);
                $poem_lines = explode("\n", $poem_content);
            } else {
                echo "File not found!";
            }
        } else {
            echo "Incorrect answer!";
        }
    } else {
        echo "Some information is missing!";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poem Display</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Dancing Script", cursive;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
            background-color: #fafafa;
            color: #333;
            margin: 0;
            padding: 40px;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .poem-container {
            height: 100vh;
            text-align: center; 
        }

        .poem-title {
            font-size: 3em;
            font-weight: bold;
            color: #4A4A4A;
            margin-bottom: 20px;
        }

        .poem-author {
            font-size: 2em;
            font-style: italic;
            color: #777;
            margin-bottom: 30px;
        }

        .poem-content {
            font-size: 1.5em;
            color: #333;
            white-space: pre-wrap;
        }

        .poem-line {
            margin: 10px 0;
        }
        a {
            font-size: 1.5em;
        }
    </style>
</head>
<body>
    <div class="poem-container">
        <div class="poem-title"><?php echo $challenge["title"] ?></div>
        <div class="poem-author"><?php echo $challenge["publisher"] ?></div> 
        <div class="poem-content">
            <?php
            // Output each line of the poem within a paragraph tag
            foreach ($poem_lines as $line) {
                echo "<p class='poem-line'>" . htmlspecialchars($line) . "</p>";
            }
            ?>
        </div>
        <a class="poem-line" href="../views/solve_challenge.php">Back to challenges</a>
    </div>
</body>
</html>