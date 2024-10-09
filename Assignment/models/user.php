<?php
class User {
    private $conn;
    private $table_name = "ethicalhackerclub.users";

    public $username;
    public $password;
    public $fullname;
    public $email;
    public $mobile;
    public $role = 0;

    // Khởi tạo đối tượng User với kết nối cơ sở dữ liệu
    public function __construct($db) {
        $this->conn = $db;
    }

    // public function __get($username) {
    //     return $this->$username;
    // }

    // public function __set($username, $value) {
    //     $this->$username = $value;
    // }

    // public function __get($password) {
    //     return $this->$password;
    // }

    // public function __set($password, $value) {
    //     $this->$password = $value;
    // }

    // public function __get($fullname) {
    //     return $this->$fullname;
    // }

    // public function __set($fullname, $value) {
    //     $this->$fullname = $value;
    // }

    // public function __get($mobile) {
    //     return $this->$mobile;
    // }

    // public function __set($mobile, $value) {
    //     $this->$mobile = $value;
    // }

    // public function __get($email) {
    //     return $this->$email;
    // }

    // public function __set($email, $value) {
    //     $this->$email = $value;
    // }

    // Tạo người dùng mới
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "(username, password, fullname, email, mobile, role) VALUES (:username,:password,:fullname,:email,:mobile,:role);";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mobile", $this->mobile);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET password=:password, fullname=:fullname, email=:email, mobile=:mobile WHERE username=:username;";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":mobile", $this->mobile);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE username=:username;";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));

        // bind values
        $stmt->bindParam(":username", $this->username);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Đọc tất cả người dùng
    public function readAll() {
        $query = "SELECT username, fullname, email, mobile FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username=:username AND password=:password";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);

        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getRole($username) {
        $query = "SELECT role FROM " . $this->table_name . " WHERE username=:username";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $stmt->bindParam(":username", $username);

        if ($stmt->execute()) {
            $role = $stmt->fetch(PDO::FETCH_ASSOC);
            return $role["role"];
        } else {
            return false;
        }
    }

    public function getInfo($info, $username) {
        $query = "SELECT $info FROM " . $this->table_name . " WHERE username=:username";
        $stmt = $this->conn->prepare($query);
        // sanitize
        $info = htmlspecialchars(strip_tags($info));
        $stmt->bindParam(":username", $username);
        
        if ($stmt->execute()) {
            $info = $stmt->fetch(PDO::FETCH_ASSOC);
            return $info;
        } else {
            return false;
        }
    }

    public function getUser() {
        $query = "SELECT username FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $array = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    array_push($array, $username);
                }
                return $array;
            }
        } else {
            return false;
        }
    }

    public function upload_exercise($title, $publisher, $description, $file_path) {
        $query = "INSERT INTO ethicalhackerclub.assignments (title, publisher, description, file_path) VALUES (:title, :publisher, :description, :file_path);";
        $stmt = $this->conn->prepare($query);
        
        $title = htmlspecialchars(strip_tags($title));
        $publisher = htmlspecialchars(strip_tags($publisher));
        $description = htmlspecialchars(strip_tags($description));
        $file_path = htmlspecialchars(strip_tags($file_path));

        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":publisher", $publisher);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":file_path", $file_path);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function get_exercise($publisher = "") {
        $query = "SELECT * FROM ethicalhackerclub.assignments";

        // if publisher is present, select the exercise that match the publisher (teacher)
        if ($publisher != null) {
            $query .= " WHERE publisher=:publisher";
            $stmt = $this->conn->prepare($query);
            $publisher = htmlspecialchars(strip_tags($publisher));
            $stmt->bindParam(":publisher", $publisher);
        } else {
            // student get all the exercise
            $stmt = $this->conn->prepare($query);
        }

        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $array = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    array_push($array, $row);
                }
                return $array;
            }
        } else {
            return false;
        }
    }

    public function delete_exercise($id, $publisher) {
        $query = "SELECT publisher,file_path FROM ethicalhackerclub.assignments WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        
        $id = htmlspecialchars(strip_tags($id));

        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            // check the publisher do this action is actually the teacher who upload the exercise
            if ($publisher === $row["publisher"]) {
                // delete the submission that match the assignment_id first
                $this->delete_submission($this->get_submission_by_assignment_id($id));
                $query = "DELETE FROM ethicalhackerclub.assignments WHERE id=:id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id", $id);
                if ($stmt->execute()) {
                    unlink("../static/uploads/teacher/".$row["file_path"]);
                    return true;
                } else {
                    return false;
                }
            
                
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_submission($student_username = "", $id = "") {
        $query = "SELECT * FROM ethicalhackerclub.submissions";
        // student can see the only submission that they submitted
        if ($student_username != null) {
            $query .= " WHERE student_username=:student_username";
            $stmt = $this->conn->prepare($query);
            $student_username = htmlspecialchars(strip_tags($student_username));
            $stmt->bindParam(":student_username", $student_username);
        // teacher see all the submission that match the assignment_id that they upload
        } else {
            $query .= " WHERE assignment_id=:id";
            $stmt = $this->conn->prepare($query);
            $id = htmlspecialchars(strip_tags($id));
            $stmt->bindParam(":id", $id);
        }

        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $array = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    array_push($array, $row);
                }
                return $array;
            }
        } else {
            return false;
        }
    }

    // Use inner join to select the submission that match the assignment_id with the id column in assignments
    public function get_submission_by_assignment_id($assignment_id) {
        $query = "SELECT submissions.id FROM ethicalhackerclub.submissions INNER JOIN ethicalhackerclub.assignments ON submissions.assignment_id = assignments.id AND assignments.id = :id";
        $stmt = $this->conn->prepare($query);
        $assignment_id = htmlspecialchars(strip_tags($assignment_id));
        $stmt->bindParam(":id", $assignment_id);
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            return $row["id"];
        } else {
            return false;
        }
    }

    public function submissions($assignment_id, $student_username, $file_path) {
        $query = "INSERT INTO ethicalhackerclub.submissions (assignment_id, student_username, file_path) VALUES (:assignment_id, :student_username, :file_path);";
        $stmt = $this->conn->prepare($query);
        
        $assignment_id = htmlspecialchars(strip_tags($assignment_id));
        $student_username = htmlspecialchars(strip_tags($student_username));
        $file_path = htmlspecialchars(strip_tags($file_path));

        $stmt->bindParam(":assignment_id", $assignment_id);
        $stmt->bindParam(":student_username", $student_username);
        $stmt->bindParam(":file_path", $file_path);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_submission($id, $student_username = "") {
        $query = "SELECT student_username, file_path FROM ethicalhackerclub.submissions WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        
        $id = htmlspecialchars(strip_tags($id));

        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            // check student do this action is acctually the student who submitted the file
            if ($student_username === $row["student_username"] || $student_username === "") {
                // if student name is null, this function is used by teacher to delete the submission
                $query = "DELETE FROM ethicalhackerclub.submissions WHERE id=:id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id", $id);
                if ($stmt->execute()) {
                    unlink("../static/uploads/student/".$row["file_path"]);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function upload_challenge($title, $publisher, $hint, $file_path) {
        $query = "INSERT INTO ethicalhackerclub.challenges (title, publisher, hint, file_path) VALUES (:title, :publisher, :hint, :file_path);";
        $stmt = $this->conn->prepare($query);
        
        $title = htmlspecialchars(strip_tags($title));
        $publisher = htmlspecialchars(strip_tags($publisher));
        $hint = htmlspecialchars(strip_tags($hint));
        $file_path = htmlspecialchars(strip_tags($file_path));

        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":publisher", $publisher);
        $stmt->bindParam(":hint", $hint);
        $stmt->bindParam(":file_path", $file_path);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_challenge($publisher = "", $id = "") {
        $query = "SELECT * FROM ethicalhackerclub.challenges";

        // if publisher is present, select the challenge that match the publisher (teacher) they uploaded
        if ($publisher != null) {
            $query .= " WHERE publisher=:publisher";
            $stmt = $this->conn->prepare($query);
            $publisher = htmlspecialchars(strip_tags($publisher));
            $stmt->bindParam(":publisher", $publisher);
        // get challenge by id to check the student answer
        } else if ($id != null) {
            $query .= " WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $id = htmlspecialchars(strip_tags($id));
            $stmt->bindParam(":id", $id);
        // get all challenge to display
        } else {
            $stmt = $this->conn->prepare($query);
        }

        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $array = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    array_push($array, $row);
                }
                return $array;
            }
            
        } else {
            return false;
        }
    }

    public function delete_challenge($id, $publisher) {
        $query = "SELECT publisher, file_path FROM ethicalhackerclub.challenges WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        
        $id = htmlspecialchars(strip_tags($id));

        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            // check the publisher do this action is actually the teacher who upload the challenge
            if ($publisher === $row["publisher"] || $publisher === "") {
                $query = "DELETE FROM ethicalhackerclub.challenges WHERE id=:id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id", $id);
                if ($stmt->execute()) {
                    unlink("../static/uploads/teacher/challenge/".$row["file_path"]);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function checkExist($column, $value) {
        // check an information in the database to prevent duplicate
        $query = "SELECT * FROM " . $this->table_name . " WHERE " . $column . "=:value;";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $column = htmlspecialchars(strip_tags($column));
        $value = htmlspecialchars(strip_tags($value));
        // bind values
        $stmt->bindParam(":value", $value);

        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num > 0) {
            return true;
        } else {
            return false;
        }
    }

    
}
