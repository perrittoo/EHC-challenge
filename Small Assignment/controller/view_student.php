<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

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

        table th, table td {
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

            table, table tbody, table tr, table td {
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
    <?php
        require_once "../models/database.php";
        require_once "../models/user.php";
        $database = new Database();
        $db = $database->getConnection();
        
        $user = new User($db);
        $stmt = $user->readAll();
        $num = $stmt->rowCount();

        if ($num > 0) {
            echo "<div class='container'>
                    <h1>Student List</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo 
                "<tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$mobile</td>
                    <td>$email</td>
                </tr>
                ";
            }
            echo 
                "</tbody>
            </table>
        </div>";
        } else {
            echo "No users found.";
        }
    ?>
    <a href="../views/index.html" class="btn btn-view">Go back to home page.</a>
</body>
</html>
