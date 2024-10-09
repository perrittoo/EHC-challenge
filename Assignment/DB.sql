CREATE DATABASE ethicalhackerclub;
USE ethicalhackerclub;

CREATE TABLE users (
    username VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mobile VARCHAR(255) NOT NULL,
    role boolean NOT NULL
);

INSERT INTO ethicalhackerclub.users (username, password, fullname, email, mobile, role) VALUES ('perryto', 'Haudeptrai2004', 'Vũ Văn Hậu', 'hauvv2904@gmail.com', '0865052194', 1);
INSERT INTO ethicalhackerclub.users (username, password, fullname, email, mobile, role) VALUES ('DVL', '123', 'Đặng Văn Long', 'dvl@gmail.com', '0123456123', 0);
INSERT INTO ethicalhackerclub.users (username, password, fullname, email, mobile, role) VALUES ('PNK', '123', 'Phạm Ngọc Khánh', 'pnk@gmail.com', '2534124124', 0);
INSERT INTO ethicalhackerclub.users (username, password, fullname, email, mobile, role) VALUES ('LTT', '123', 'Lê Trung Tín', 'ltt@gmail.com', '6765133451', 0);
INSERT INTO ethicalhackerclub.users (username, password, fullname, email, mobile, role) VALUES ('PTH', '123', 'Phan Thuận Hóa', 'pth@gmail.com', '8543244513', 0);
INSERT INTO ethicalhackerclub.users (username, password, fullname, email, mobile, role) VALUES ('admin', 'admin123', 'Anh Admin', 'admin@admin.admin', '0000000000', 1);

CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    publisher VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255),
    FOREIGN KEY (publisher) REFERENCES users(username)
);

INSERT INTO ethicalhackerclub.assignments (title, publisher, description, file_path) VALUES ('Bai 1', 'admin', 'Giai phuong trinh', '5057dc49e8209da73f7b52138f45b915');
INSERT INTO ethicalhackerclub.assignments (title, publisher, description, file_path) VALUES ('Bai 2', 'admin', 'Cung la giai phuong trinh', '876a948d4816c3a3d884f82a915605d3');

CREATE TABLE submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT,
    student_username VARCHAR(255),
    file_path VARCHAR(255),
    FOREIGN KEY (assignment_id) REFERENCES assignments(id),
    FOREIGN KEY (student_username) REFERENCES users(username)
);


CREATE TABLE challenges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    publisher VARCHAR(255) NOT NULL,
    hint TEXT,
    file_path VARCHAR(255),
    FOREIGN KEY (publisher) REFERENCES users(username)
);

INSERT INTO ethicalhackerclub.challenges (title, publisher, hint, file_path) VALUES ('Challenge 1', 'admin', '1. 1948-1955\r\n\r\n2. Bản chép ở trên được in trong tập Tia nắng (NXB Văn học, 1983) và tập Người chiến sĩ (NXB Văn nghệ, 1956). \r\n\r\n3. Theo Thơ Việt Nam 1945-1960 (NXB Văn học, 1960) thì sau câu “Lòng dân ta yêu nước thương nhà” còn có thêm bốn câu:\r\nNhững làng xóm mọc lên luỹ thép\r\nNhững ruộng vườn thành bể dầu sôi\r\nQuân giặc kinh hoàng trên đất chết\r\nMỗi bước đi lạnh toát mồ hôi\r\n\r\n4. Và câu “Lòng ta bát ngát ánh bình minh” in là: “Đây những người con Hồ Chí Minh”.\r\n\r\n5. Tác giả Nguyễn Duy', 'dat nuoc.txt');
INSERT INTO ethicalhackerclub.challenges (title, publisher, hint, file_path) VALUES ('Challenge 2', 'admin', '1. Tác giả Xuân Quỳnh.\r\n\r\n2. Sáng tác năm 1967 trong chuyến đi thực tê ở vùng biển Diêm Điền (Thái Bình), là một bài thơ đặc sắc viết về tình yêu, rất tiêu biểu cho phong cách thơ Xuân Quỳnh.\r\n\r\n3. Bài thơ in trong tập Hoa dọc chiến hào\r\n\r\n4. Thơ 5 chữ.\r\n\r\n5. Khi nào ta yêu nhau?', 'song.txt');
