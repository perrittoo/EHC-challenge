<?php
    session_start();
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
    <title>Student Management</title>
    <link rel="stylesheet" href="../static/css/teacher.css">
</head>
<body>
    <header>
        <div class="logo">📒 TeacherPortal</div>
        <nav>
            <a href="../controller/logout.php">Logout</a>
            <a href="upload_exercise.php">Upload Assignment</a>
            <a href="view_user.php">View</a>
            <a href="create_challenge.php">Challenge</a>
        </nav>
    </header>

    <main>
        <h1>Student Management</h1>
        <div class="forms-container">
            <div class="form-card">
                <h2>Add Student</h2>
                <form method="POST" action="../controller/teacher_controller.php">
                    <input type="hidden" value="add" name="action" required>

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password</label>
                    <input type="text" id="password" name="password" required>

                    <label for="fullname">Fullname</label>
                    <input type="text" id="fullname" name="fullname" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="mobile">Mobile</label>
                    <input type="text" id="mobile" name="mobile" required>

                    <button class="button-9" role="button" type="submit">Add Student</button>
                </form>
            </div>

            <div class="form-card">
                <h2>Update Student</h2>
                <h3>If you do not want to update any fields, you do not need to enter them.</h3>
                <form method="POST" action="../controller/teacher_controller.php">
                    <input type="hidden" value="update" name="action" require>

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" require>

                    <label for="password">Password</label>
                    <input type="text" id="password" name="password">

                    <label for="fullname">Fullname</label>
                    <input type="text" id="fullname" name="fullname">

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">

                    <label for="mobile">Mobile</label>
                    <input type="text" id="mobile" name="mobile">

                    <button class="button-9" role="button" type="submit">Update Student</button>
                </form>
            </div>

            <div class="form-card">
                <h2>Delete Student</h2>
                <form id="delete-student-form" method="POST" action="../controller/teacher_controller.php">
                    <input type="hidden" value="delete" name="action" required>

                    <label for="delete-student">Username</label>
                    <input type="text" id="delete-student" name="delete-student" require>
                    <button class="button-9" role="button" type="submit">Delete Student</button>
                </form>
            </div>
        </div>

        
    </main>
</body>
</html>
