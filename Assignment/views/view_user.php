<?php
  require_once("../models/database.php");
  require_once("../models/user.php");
  session_start();
  $database = new Database();
  $db = $database->getConnection();

  $user = new User($db);
  $stmt = $user->readAll();
  $num = $stmt->rowCount();
  if (!isset($_SESSION["username"])) {
    header("Location: login.html");
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f9;
      height: 100vh;
      margin: 0;
    }

    header {
      background-color: #e9e9e9;
      display: flex;
      justify-content: space-between;
      padding: 10px 20px;
      align-items: center;
      border-bottom: 2px solid #ccc;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
    }

    nav a {
      margin-left: 20px;
      text-decoration: none;
      color: #333;
      font-weight: bold;
    }
    /* .main {
      display: flex;
      justify-content: center;
      align-items: center;
    } */

    .container {
      width: 80%;
      margin: 20px auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
      padding: 0;
      table-layout: fixed;
    }

    table thead {
      background-color: #3498db;
      color: #fff;
    }

    table th,
    table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    table tbody tr:hover {
      background-color: #f1f1f1;
    }

    table th {
      font-weight: bold;
    }

    table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    table tbody tr:nth-child(odd) {
      background-color: #fff;
    }

    @media (max-width: 768px) {
      .container {
        width: 95%;
      }

      table thead {
        display: none;
      }

      table,
      table tbody,
      table tr,
      table td {
        display: block;
        width: 100%;
      }

      table tr {
        margin-bottom: 15px;
      }

      table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
      }

      table td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 15px;
        font-weight: bold;
        text-align: left;
      }
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      font-size: 16px;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s, transform 0.3s;
      margin: 10px 0;
    }

    .btn-view {
      background-color: #e4e73c;
    }

    .btn-view:hover {
      background-color: #c4c72b;
    }
  </style>
</head>

<body>
  <header>
    <div class="logo">📒 ViewPortal</div>
    <nav>
        <a href="login.html">Logout</a>
        <a href="upload_exercise.php">Upload Assignment</a>
        <?php if ($_SESSION["role"] == "teacher"): ?>
          <a href="teacher.php">Student Management</a>
        <?php else: ?>
          <a href="student.php">Student Management</a>
        <?php endif; ?>
        <?php if ($_SESSION["role"] == "teacher"): ?>
          <a href="create_challenge.php">Challenge</a>
        <?php else: ?>
          <a href="solve_challenge.php">Challenge</a>
        <?php endif; ?>
    </nav>
  </header>
  <div class="main">
    <h1>Current User</h1>
    <div class="container">
      <table>
        <thead>
        <tr>
          <th>Username</th>
          <th>Fullname</th>
          <th>Email</th>
          <th>Mobile</th>
        </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $_SESSION["username"]; ?></td>
            <td><?php echo $user->getInfo("password", $_SESSION["username"])["password"]; ?></td>
            <td><?php echo $user->getInfo("email", $_SESSION["username"])["email"]; ?></td>
            <td><?php echo $user->getInfo("mobile", $_SESSION["username"])["mobile"]; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php

  if ($num > 0) {
    echo "<div class='container'>
                    <table>
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Mobile</th>
                            </tr>
                        </thead>
                        <tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      echo
        "<tr>
                    <td>$username</td>
                    <td>$fullname</td>
                    <td>$email</td>
                    <td>$mobile</td>
                </tr>
                ";
    }
    echo
      "</tbody>
            </table>
        </div>";
  }
  ?>
  </div>
</body>

</html>