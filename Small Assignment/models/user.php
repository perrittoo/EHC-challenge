<?php
class User {
    private $conn;
    private $table_name = "students.myStudents";

    public $id;
    public $name;
    public $mobile;
    public $email;

    // Khởi tạo đối tượng User với kết nối cơ sở dữ liệu
    public function __construct($db) {
        $this->conn = $db;
    }

    // public function __get($id) {
    //     return $this->$id;
    // }

    // public function __set($id, $value) {
    //     $this->$id = $value;
    // }

    // public function __get($name) {
    //     return $this->$name;
    // }

    // public function __set($name, $value) {
    //     $this->$name = $value;
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
        $query = "INSERT INTO " . $this->table_name . " VALUES (:id,:name,:mobile,:email);";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":mobile", $this->mobile);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, mobile=:mobile, email=:email WHERE id=:id;";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":mobile", $this->mobile);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id;";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Đọc tất cả người dùng
    public function readAll() {
        $query = "SELECT id, name, mobile, email FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function checkExist($column, $value) {
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