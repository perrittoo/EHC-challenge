<?php  
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.html");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="../static/css/teacher.css">
</head>
<body>
    <header>
        <div class="logo">📒 StudentPortal</div>
        <nav>
            <a href="../controller/logout.php">Logout</a>
            <a href="view_user.php">View</a>
            <a href="upload_exercise.php">Assignment</a>
            <a href="solve_challenge.php">Challenge</a>
        </nav>
    </header>

    <main>
        <h1>Student Management</h1>
        <div class="forms-container">

            <div class="form-card">
                <h2>Update Student</h2>
                <h3>If you do not want to update any fields, you do not need to enter them.</h3>
                <form method="POST" action="../controller/teacher_controller.php">
                    <label for="password">Password</label>
                    <input type="text" id="password" name="password">
                    
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">

                    <label for="mobile">Mobile</label>
                    <input type="text" id="mobile" name="mobile">

                    <button class="button-9" role="button" type="submit">Update your Information</button>
                </form>
            </div>

        
        </div>
</body>
</html>
