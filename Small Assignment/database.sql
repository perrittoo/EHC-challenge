CREATE DATABASE students;
USE students;

CREATE TABLE myStudents (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    mobile VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);

INSERT INTO students.myStudents VALUES ('HE180000', 'Nguyen Van A',   '0987654321', 'anv@gmail.com');
INSERT INTO students.myStudents VALUES ('HE182324', 'Vu Van Hau',     '0865052194', 'hauvvhe182324@fpt.edu.vn');
INSERT INTO students.myStudents VALUES ('HE011347', 'Dang Van Long',  '0123456789', 'dvl@gmail.com');
INSERT INTO students.myStudents VALUES ('HE173264', 'Pham Ngoc Khanh','0423412138', 'pnk@gmail.com');
INSERT INTO students.myStudents VALUES ('HE148134', 'Pham Viet Thang','0624231572', 'pvt@gmail.com');