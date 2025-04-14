<?php
require("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['delete_room'])) {
    $classroom_id = mysqli_real_escape_string($con, $_GET['delete_room']);

    // Delete the classroom
    $sql = "DELETE FROM classrooms WHERE classroom_id = '$classroom_id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        // Optional: Add a success message to display later
        $_SESSION['message'] = "Classroom deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete classroom.";
    }

    // Redirect back to classroom list
    header("Location: admin_classroom.php");
    exit();
} else {
    // If no classroom ID is provided, redirect
    header("Location: admin_classroom.php");
    exit();
}
?>
