<?php 
    function checkValidId($str) {
        return in_array(substr($str , 0 , 2) , ["HS" , "HE" , "HF"]) && strlen(substr($str , 2)) <= 6;
    }

    function display($str) {
        for ($i = 0; $i < count($students_list); $i++) {
            echo $students_list[$i][$str];
        }
    }
    

    function remove($tag) {
        echo    "<script>
                    var div = document.querySelector('".$tag."');
                    div.parentNode.removeChild(div);
                </script>";
    }


    //connect to db
    $servername = "localhost";
    $database = "students";
    $username = "perrito";
    $password = "Vandau2004@";

    // Create connection

    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection

    if (!$conn) {

        die("Connection failed: " . mysqli_connect_error());

    }
    
    $students_list = array();
    $query = "SELECT * from students.myStudents;";
    $res = mysqli_query($conn , $query);
    if ($res) {
        while ($row = mysqli_fetch_row($res)) {
            array_push($students_list , $row);
        }
    }
    

    if (isset($_POST["studentId"], $_POST["studentName"] , $_POST["studentMobile"] , $_POST["studentEmail"])) {
        $id = $_POST["studentId"];
        $name = $_POST["studentName"];
        $mobile = $_POST["studentMobile"];
        $email = $_POST["studentEmail"];
        if (strlen(trim($id)) > 0 && strlen(trim($name)) > 0 && strlen(trim($mobile)) > 0 && strlen(trim($email)) > 0) {
            if (checkValidId($id) && strlen($mobile) == 10) {
                $check_id_exist = false;
                $check_mobile_exist = false;
                $check_email_exist = false;
                for ( $i = 0; $i < count($students_list); $i++) {
                    if ($students_list[$i][0] == $id) {
                        $check_user_exist = true;
                    }
                    if ($students_list[$i][2] == $mobile) {
                        $check_mobile_exist = true;
                    }
                    if ($students_list[$i][3] == $email) {
                        $check_email_exist = true;
                    }
                }
                if ($check_id_exist) {
                    $mess = "<h1>Student ID is invalid or already exists.</h1>";
                } else if ($check_mobile_exist) {
                    $mess = "<h1>Mobile number is invalid or already exists.</h1>";
                } else if ($check_email_exist) {
                    $mess = "<h1>Email is invalid or already exists.</h1>";
                } else {
                    $queryUpdate = "INSERT INTO students.myStudents () VALUES ('$id', '$name' , $mobile, '$email');";
                    $resUpdate = mysqli_query($conn, $queryUpdate);
                    $mess = "<h1>Add student successfully.</h1>";
                }
            } else
                $mess = "<h1>Student ID is invalid.</h1>";

            
        } else {
            $mess = "Don't try to fool me, you need to enter something!";
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 40px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"], input[type="tel"] {
            width: 250px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        button[type="submit"] {
            border-radius: 5px;
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .render {
            display: flex;
            height: 600px;
            flex-wrap: wrap;
            align-content: space-between;
        }

        .student-info {
            margin: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            min-width: 300px;
        }

        .student-info h2 {
            margin-top: 0;
        }

        .student-info p {
            margin-bottom: 5px;
        }

        .student-info span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form action="" method="POST">
        <label for="studentId">Student ID:</label>
        <input type="text" id="studentId" name="studentId" placeholder="HE180000" required><br>

        <label for="studentName">Name:</label>
        <input type="text" id="studentName" name="studentName" placeholder="Nguyen Van A" required><br>

        <label for="studentMobile">Mobile:</label>
        <input type="tel" id="studentMobile" pattern="[0-9]+" placeholder="0123456789" name="studentMobile" required><br>

        <label for="studentEmail">Email:</label>
        <input type="email" id="studentEmail" name="studentEmail" placeholder="abc@gmail.com" required><br>

        <button type="submit">Add</button>
    </form>

    <?php 
        if (isset($mess)) {
            echo $mess;
        }
    ?>

    <div class="render">
    <?php 
        
        for ( $i = 0; $i < count($students_list); $i++) {
            echo    "<div class='student-info' id='student".($i + 1)."'>
                        <h2>Student Details</h2>
                        <p>Student ID: <span id='studentId-output'>".$students_list[$i][0]."</span></p>
                        <p>Name: <span id='name-output'>".$students_list[$i][1]."</span></p>
                        <p>Mobile: <span id='mobile-output'>".$students_list[$i][2]."</span></p>
                        <p>Email: <span id='email-output'>".$students_list[$i][3]."</span></p>
                        <form action='' method='POST'>
                        <input type='submit' name=update".($i + 1)." value='Update'></input>
                        <input type='submit' name=delete".($i + 1)." value='Delete'></input>
                    </div>";
        }



        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            for ($i = 0; $i < count($students_list); $i++) {
                
                if (isset($_POST["delete".($i + 1)])) {
                    $query = "DELETE FROM students.myStudents WHERE id='".$students_list[$i][0]."'";
                    $res = mysqli_query($conn , $query);
                }
            }
        }
        

    ?>
    </div>
    
  
</body>
</html>
