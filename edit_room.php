<?php
require("connection.php");

$classroom_id = $_GET['edit_room'];
$sql = "SELECT * FROM classrooms WHERE classroom_id = '$classroom_id'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
    // Get the new values from the form
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];
    $class_time = $_POST['class_time'];

    // Update the classroom record
    $sql = "UPDATE classrooms 
            SET subject_name = '$subject_name', subject_code = '$subject_code', class_time = '$class_time' 
            WHERE classroom_id = '$classroom_id'";
    $query = mysqli_query($con, $sql);

    if ($query) {
        header("Location: admin_classroom.php"); // Redirect to the classrooms list
        exit();
    } else {
        echo "Error updating classroom details.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Classroom</title>
</head>
<body>

    <h2>Edit Classroom</h2>
    <form method="POST">
        <div>
            <label for="subject_name">Subject Name:</label>
            <input type="text" name="subject_name" value="<?php echo $row['subject_name']; ?>" required>
        </div>
        <div>
            <label for="subject_code">Subject Code:</label>
            <input type="text" name="subject_code" value="<?php echo $row['subject_code']; ?>" required>
        </div>
        <div>
            <label for="class_time">Class Time:</label>
            <input type="text" name="class_time" value="<?php echo $row['class_time']; ?>" required>
        </div>
        
        <div>
            <input type="submit" name="submit" value="Update Classroom">
        </div>
    </form>

</body>
</html>
