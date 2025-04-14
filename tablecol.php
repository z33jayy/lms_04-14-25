<?php
require("connection.php");

// Create the user_information table for storing users (students, teachers, admins)
$sql_user = "CREATE TABLE IF NOT EXISTS user_information (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    student_id INT DEFAULT NULL UNIQUE,
    teacher_id BIGINT DEFAULT NULL UNIQUE, 
    fullname VARCHAR(250) NOT NULL,
    address VARCHAR(250) NOT NULL,
    CellphoneNum BIGINT NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    Birthdate DATE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Student', 'Teacher', 'Admin') NOT NULL
)";
$query_user = mysqli_query($con, $sql_user);

// Create the classrooms table for managing class subjects and linking them to teachers
$sql_classroom = "CREATE TABLE IF NOT EXISTS classrooms (
    classroom_id INT PRIMARY KEY AUTO_INCREMENT,
    subject_name VARCHAR(255) NOT NULL,
    subject_code VARCHAR(50) NOT NULL,
    class_time VARCHAR(50) NOT NULL,
    instructor_id BIGINT NOT NULL
)";
$query_classroom = mysqli_query($con, $sql_classroom);

// Drop existing foreign key (if exists) between classrooms and user_information
@mysqli_query($con, "ALTER TABLE classrooms DROP FOREIGN KEY classrooms_ibfk_1");

// Add foreign key to link classrooms to user_information (teacher_id), with cascading delete
$add_fk = "ALTER TABLE classrooms
ADD CONSTRAINT classrooms_ibfk_1
FOREIGN KEY (instructor_id) REFERENCES user_information(teacher_id)
ON DELETE CASCADE";
mysqli_query($con, $add_fk);

// Create the classroom_students table to map students to classrooms
$sql_class_students = "CREATE TABLE IF NOT EXISTS classroom_students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    classroom_id INT,
    student_id INT,
    FOREIGN KEY (classroom_id) REFERENCES classrooms(classroom_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES user_information(id) ON DELETE CASCADE
)";
mysqli_query($con, $sql_class_students);

// Remove redundant teach_name column from classrooms table if it exists
@mysqli_query($con, "ALTER TABLE classrooms DROP COLUMN teach_name");

?>
