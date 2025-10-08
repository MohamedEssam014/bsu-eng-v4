CREATE DATABASE IF NOT EXISTS university_v4 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE university_v4;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','staff','student') NOT NULL DEFAULT 'student',
  email VARCHAR(200),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_number VARCHAR(50) UNIQUE,
  name_en VARCHAR(200),
  name_ar VARCHAR(200),
  email VARCHAR(200),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_code VARCHAR(50) UNIQUE,
  name_en VARCHAR(200),
  name_ar VARCHAR(200),
  instructor_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE lectures (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT,
  staff_id INT,
  title_en VARCHAR(255),
  title_ar VARCHAR(255),
  filename VARCHAR(255),
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
  FOREIGN KEY (staff_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  course_id INT,
  grade VARCHAR(10),
  semester VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE subscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  course_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed admin (password: admin123) bcrypt hash
INSERT INTO users (username, password_hash, role, email) VALUES
('admin', '$2y$10$uV4f7y8L8nQw0YwDq1o3be7xkzjYxQZkY0G1y2Z3a4b5c6d7e8f9', 'admin', 'admin@bsu.edu.eg');

-- sample staff
INSERT INTO users (username, password_hash, role, email) VALUES
('staff1', '$2y$10$uV4f7y8L8nQw0YwDq1o3be7xkzjYxQZkY0G1y2Z3a4b5c6d7e8f9', 'staff', 'staff1@bsu.edu.eg');

-- sample students
INSERT INTO students (student_number, name_en, name_ar, email) VALUES
('2025001','Mohamed Essam','محمد عصام','mohamed@example.com'),
('2025002','Aya Ali','آية علي','aya@example.com');

INSERT INTO users (username, password_hash, role, email) VALUES
('student1', '$2y$10$uV4f7y8L8nQw0YwDq1o3be7xkzjYxQZkY0G1y2Z3a4b5c6d7e8f9', 'student', 'mohamed@example.com');

INSERT INTO courses (course_code, name_en, name_ar, instructor_id) VALUES
('COM101','Intro to Communications','مقدمة في الاتصالات',2);

INSERT INTO subscriptions (student_id, course_id) VALUES
(1,1),(2,1);
