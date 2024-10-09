<?php 
    require_once '../models/user.php';
    require_once '../models/database.php';
    $database = new Database();
    $db = $database->getConnection();
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.html");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <link rel="stylesheet" href="../static/css/upload.css">
</head>
<body>
    <header>
        <div class="logo">📒 TeacherPortal</div>
        <nav>
            <a href="../controller/logout.php">Logout</a>
            <?php if ($_SESSION["role"] == "teacher"): ?>
            <a href="teacher.php">Student Management</a>
            <?php else: ?>
            <a href="student.php">Student Management</a>
            <?php endif; ?>
            <a href="view_user.php">View</a>
            <?php if ($_SESSION["role"] == "teacher"): ?>
            <a href="create_challenge.php">Challenge</a>
            <?php else: ?>
            <a href="solve_challenge.php">Challenge</a>
            <?php endif; ?>
        </nav>
    </header>
    <?php if ($_SESSION["role"] == "teacher"): ?>
    
    <h1 style="text-align: center;margin-top: 20px;font-size: 2em;color: #3E8E41;">Upload File</h1>
    <form action='../controller/upload_assignment.php' method='POST' enctype='multipart/form-data'>
        
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Short description:</label>
        <textarea type="text" id="description" name="description"></textarea>
        
        <label for="assignment_file">Upload File:</label>
        <input type='file' id='assignment_file' name='assignment_file'>
        <button type='submit' name='upload_exercise'>Upload your Assignment</button>
    </form>
        
    <?php endif; ?>
    
    <?php 
        $user = new User($db);
        if ($_SESSION["role"] == "teacher") {
            $exercises = $user->get_exercise($_SESSION["username"]);
        } else {
            $exercises = $user->get_exercise();
        }
        if ($exercises) 
            foreach ($exercises as $exercise): ?>
                    <h1 class="assignment-title"> <?php echo $exercise['title']; ?></h1>
                    <p class="assignment-description"> <?php echo $exercise['description']; ?></p>
                    <a class="assignment-download" href='../static/teacher/<?php echo $exercise['file_path']; ?>'>Download the assignment file.</a>
                <?php if ($_SESSION["role"] == "teacher"): ?> 
                    <a class="assignment-delete" href="../controller/delete_exercise.php?id=<?php echo $exercise['id']; ?>">Delete</a>
                <?php else: ?>
                    <form action='../controller/submission.php' method='POST' enctype='multipart/form-data'>
                        <input type="hidden" name="id" value="<?php echo $exercise['id']; ?>">
                        <label for="submission_file">Upload File:</label>
                        <input type='file' id='submission_file' name='submission_file'>
                        <button type='submit' name='upload_exercise'>Upload your Assignment</button>
                    </form>
                <?php endif; ?>
                <?php 
                    if ($_SESSION["role"] == "teacher") 
                        $submissions = $user->get_submission("", $exercise['id']);
                    else 
                        $submissions = $user->get_submission($_SESSION["username"]);
                    if ($submissions) 
                        foreach ($submissions as $submission): ?>
                            <?php if ($submission["assignment_id"] == $exercise["id"]): ?>
                                <h2 style="text-align: center;margin-top: 20px;font-size: 2em;color: #3E8E41;">Student: <?php echo $submission['student_username']; ?></h2>
                                <a class="assignment-download" href='../static/student/<?php echo $submission['file_path']; ?>'>Download student submission.</a>
                                <a class="assignment-delete" href="../controller/delete_exercise.php?id=<?php echo $exercise['id']; ?>">Delete</a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    
                
            <?php endforeach; ?>
            
        

</body>
</html>