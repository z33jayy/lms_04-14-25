<?php
require("connection.php");

if (isset($_POST['add_student'])) {
    $classroom_id = $_POST['classroom_id'];  // Classroom ID from the form
    $student_name = trim($_POST['student_name']);  // Student name input from the form

    // Find the student ID based on the name and role
    $find = "SELECT id FROM user_information WHERE fullname = '$student_name' AND role = 'Student'";
    $res = mysqli_query($con, $find);
    if (mysqli_num_rows($res) > 0) {
        $student = mysqli_fetch_assoc($res);
        $student_id = $student['id'];  // Get the student ID

        // Check if the student is already in the classroom
        $check_existing = "SELECT * FROM classroom_students WHERE classroom_id = $classroom_id AND student_id = $student_id";
        $exists = mysqli_query($con, $check_existing);
        if (mysqli_num_rows($exists) == 0) {
            // If not already in the classroom, insert the student into the classroom_students table
            $insert = "INSERT INTO classroom_students (classroom_id, student_id) VALUES ($classroom_id, $student_id)";
            mysqli_query($con, $insert);
        }
    }

    // Redirect back to the student management page
    header("Location: student.php");
    exit();
}

if (isset($_POST['remove_student'])) {
    $student_id = $_POST['remove_id'];  // The student ID to remove
    $classroom_id = $_POST['classroom_id'];  // Classroom ID
    $delete = "DELETE FROM classroom_students WHERE student_id = $student_id AND classroom_id = $classroom_id";
    mysqli_query($con, $delete);  // Remove the student from the classroom_students table

    // Redirect back to the student management page
    header("Location: student.php");
    exit();
}

?>



